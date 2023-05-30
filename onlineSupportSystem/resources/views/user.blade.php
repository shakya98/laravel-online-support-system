<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <!-- Section 1 -->
    <div class="container my-4">
        <button id="logoutBtn" class="btn btn-primary">Logout</button>
    </div>

    <!-- Section 2 -->
    <div class="container my-4">
        <h2>Tickets</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Problem Description</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Reference Number</th>
                    <th>Open?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ticketTableBody">
                <!-- Table data will be synced here -->
            </tbody>
        </table>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="replyForm">
                        <div class="form-group">
                            <label for="reply">Reply:</label>
                            <textarea class="form-control" id="reply" name="reply" rows="3" required></textarea>
                        </div>
                        <input type="hidden" id="ticketId" name="ticketId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitReply">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            if (!token) {
                window.location.href = "{{ url('login') }}";
            }

            $.ajax({
                type: 'GET',
                url: '{{ url("/api/getTickets") }}',
                headers: {
                    "Authorization": "Bearer " + token
                },
                success: function(response) {
                    let ticketTableBody = "";
                    response.forEach(ticket => {
                        ticketTableBody += `
                            <tr>
                                <td>${ticket.id}</td>
                                <td>${ticket.customer_name}</td>
                                <td>${ticket.problem_description}</td>
                                <td>${ticket.email}</td>
                                <td>${ticket.phone_number}</td>
                                <td>${ticket.reference_number}</td>
                                <td>${ticket.is_open ? 'Yes' : 'No'}</td>
                                <td><button data-id="${ticket.id}" class="btn btn-primary reply-btn">Reply</button></td>
                            </tr>
                        `;
                    });
                    $('#ticketTableBody').html(ticketTableBody);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Something went wrong. Please try again.");
                }
            });

            $('#logoutBtn').click(function() {
                localStorage.removeItem('token');
                window.location.href = "{{ url('login') }}";
            });

            $(document).on('click', '.reply-btn', function() {
                const ticketId = $(this).data('id');
                $('#ticketId').val(ticketId); // Set the ticketId in the hidden input field of the form
                $('#replyModal').modal('show'); // Open the reply modal
            });

            $('#submitReply').click(function() {
                const ticketId = $('#ticketId').val();
                const reply = $('#reply').val();

                $.ajax({
                    type: 'POST',
                    url: `/api/reply/${ticketId}`,
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    data: {
                        reply: reply
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Reply success:', response);
                        // Refresh the table
                        $.ajax({
                            type: 'GET',
                            url: '{{ url("/api/getTickets") }}',
                            headers: {
                                "Authorization": "Bearer " + token
                            },
                            success: function(response) {
                                let ticketTableBody = "";
                                response.forEach(ticket => {
                                    ticketTableBody += `
                    <tr>
                        <td>${ticket.id}</td>
                        <td>${ticket.customer_name}</td>
                        <td>${ticket.problem_description}</td>
                        <td>${ticket.email}</td>
                        <td>${ticket.phone_number}</td>
                        <td>${ticket.reference_number}</td>
                        <td>${ticket.is_open ? 'Yes' : 'No'}</td>
                        <td><button data-id="${ticket.id}" class="btn btn-primary reply-btn">Reply</button></td>
                    </tr>
                `;
                                });
                                $('#ticketTableBody').html(ticketTableBody);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("Refresh error:", textStatus, errorThrown);
                                alert("Failed to refresh the table. Please try again.");
                            }
                        });

                        // Close the modal
                        $('#replyModal').modal('hide');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Reply error:", textStatus, errorThrown);
                        alert("Failed to submit reply. Please try again.");
                    }
                });
            });
        });
    </script>
</body>

</html>