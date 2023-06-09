<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <!-- Section 1 -->
                <div>
                    <a href="/login" class="btn btn-primary">Login</a>
                    <a href="/register" class="btn btn-secondary">Register</a>
                </div>

                <!-- Section 2 -->
                <div class="mt-4">
                    <h1>Welcome to Online Support System</h1>
                </div>
                <div class="mt-4">
                    <form id="addTicketForm" method="POST" action="{{ url('/addTicket') }}">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" name="customer_name" placeholder="Customer Name" required />
                        </div>
                        <div class="form-group">
                            <label for="problem_description">Problem Description</label>
                            <input type="text" name="problem_description" placeholder="Problem Description" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <label for="Phone Number">Phone number</label>
                            <input type="text" name="phone_number" placeholder="Phone Number" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Section 3 -->
                <div class="mt-4">
                    <h3>Check Ticket Status</h3>
                    <form id="getTicketDataForm" method="POST" action="{{ url('/getSupportTicketData') }}">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" name="customer_name" placeholder="Customer Name" required />
                        </div>
                        <div class="form-group">
                            <label for="reference_number">Reference Number</label>
                            <input type="text" name="reference_number" placeholder="Reference Number" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div id="ticketData"></div>
                    <div id="repliesData"></div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Bootstrap and JQuery JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- AJAX form submission and response handling -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#addTicketForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/api/addTicket',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Ticket Added Successfully!');
                    },
                    error: function(response) {
                        alert('Failed to Add Ticket!');
                    }
                });
            });

            // $('#getTicketDataForm').on('submit', function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         type: 'POST',
            //         url: '/api/getSupportTicketData',
            //         data: $(this).serialize(),
            //         success: function(response) {
            //             $('#ticketData').html(JSON.stringify(response));
            //         },
            //         error: function(response) {
            //             alert('Failed to Get Ticket Data!');
            //         }
            //     });
            // });
            $('#getTicketDataForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/api/getSupportTicketData',
                    data: $(this).serialize(),
                    success: function(response) {
                        var isOpen = response.support_ticket.is_open === 1 ? 'Open' : 'Closed';
                        $('#ticketData').html('<div class="card mt-4"><div class="card-body">' +
                            '<h5 class="card-title">Support Ticket</h5>' +
                            '<p class="card-text">Customer Name: ' + response.support_ticket.customer_name + '</p>' +
                            '<p class="card-text">Problem Description: ' + response.support_ticket.problem_description + '</p>' +
                            '<p class="card-text">Email: ' + response.support_ticket.email + '</p>' +
                            '<p class="card-text">Phone Number: ' + response.support_ticket.phone_number + '</p>' +
                            '<p class="card-text">Reference Number: ' + response.support_ticket.reference_number + '</p>' +
                            '<p class="card-text">Ticket status: ' + isOpen + '</p>' +
                            '<p class="card-text">Created At: ' + response.support_ticket.created_at + '</p>' +
                            '</div></div>');

                        var repliesHTML = '<div class="card mt-4"><div class="card-body">' +
                            '<h5 class="card-title">Replies</h5>';

                        response.replies.forEach(function(reply) {
                            repliesHTML += 
                                '<p class="card-text">Reply: ' + reply.reply + '</p>';
                        });

                        repliesHTML += '</div></div>';

                        $('#repliesData').html(repliesHTML);
                    },
                    error: function(response) {
                        alert('Failed to Get Ticket Data!');
                    }
                });
            });
        });
    </script>
</body>

</html>