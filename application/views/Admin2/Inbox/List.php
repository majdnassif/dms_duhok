<?php if (isset($page_title)): ?>
    <div class="page-title">
        <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
            </ol>
        </div>
    </div>
<?php endif; ?>

<style>
    .inbox-container {
        display: flex;
        flex-direction: row;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        min-height: calc(100vh - 200px);
    }

    .inbox-messages-column {
        width: 40%;
        border-right: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .inbox-details-column {
        width: 60%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    /* Collapsed state */
    .inbox-container.collapsed .inbox-messages-column {
        width: 0;
        overflow: hidden;
        padding: 0;
        margin: 0;
        border: none;
    }

    .inbox-container.collapsed .inbox-details-column {
        width: 100%;
    }

    /* Expanded details state */
    .inbox-container.collapsed .inbox-details-header {
        position: relative;
    }

    .detail-header-actions {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .inbox-actions {
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8f9fa;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .inbox-filter-section {
        padding: 15px;
        background-color: #f8f9fa;
        display: none;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .inbox-message-list {
        flex: 1;
        overflow-y: auto;
        border-bottom: 1px solid #e9ecef;
    }

    .inbox-message {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }

    .inbox-message:hover {
        background-color: #f8f9fa;
    }

    .inbox-message.selected, .inbox-message.active {
        background-color: #e3f2fd;
    }

    .inbox-message.unread {
        background-color: #f0f7ff;
    }

    .inbox-message.unread:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background-color: #007bff;
    }

    .inbox-message.unread .inbox-message-from,
    .inbox-message.unread .inbox-message-subject {
        font-weight: 600;
    }

    .inbox-message-indicator {
        margin-right: 10px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #007bff;
        display: none;
    }

    .inbox-message.unread .inbox-message-indicator {
        display: block;
    }

    .inbox-message-content {
        flex: 1;
        min-width: 0;
    }

    .inbox-message-from {
        font-size: 14px;
        margin-bottom: 3px;
    }

    .inbox-message-subject {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 3px;
    }

    .inbox-message-preview {
        color: #777;
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .inbox-message-date {
        min-width: 70px;
        text-align: right;
        font-size: 12px;
        color: #777;
    }

    .inbox-message-icons {
        margin-right: 10px;
        display: flex;
        align-items: center;
        font-size: 18px;
    }

    .inbox-message-icons i {
        margin-right: 5px;
    }

    .inbox-message-icons i:first-child {
        color: #28a745;
    }

    .inbox-message-icons i:last-child {
        color: #007bff;
        margin-right: 0;
    }

    .inbox-message-detail {
        padding: 15px;
        background-color: #fff;
        flex: 1;
        overflow-y: auto;
    }

    .inbox-detail-header {
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 15px;
    }

    .inbox-detail-subject {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .inbox-detail-meta {
        display: flex;
        justify-content: space-between;
        color: #777;
        font-size: 13px;
    }

    .inbox-detail-body {
        padding: 15px 0;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
    }

    .search-wrapper input {
        width: 200px;
        margin-right: 10px;
    }

    .search-wrapper button {
        position: absolute;
        right: 8px;
        top: 8px;
        background: none;
        border: none;
        color: #777;
    }

    .badge-count {
        background-color: #28a745;
        color: white;
        border-radius: 10px;
        padding: 2px 6px;
        font-size: 11px;
    }

    .inbox-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 30px;
    }

    .inbox-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 30px;
        color: #777;
    }

    .inbox-empty i {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .inbox-empty p {
        text-align: center;
    }

    /* Spinner */
    .inbox-spinner {
        border: 3px solid #f3f3f3;
        border-radius: 50%;
        border-top: 3px solid #28a745;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .inbox-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .inbox-pagination .pages {
        display: flex;
    }

    .inbox-pagination .pages .page {
        margin: 0 2px;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
    }

    .inbox-pagination .pages .page.active {
        background-color: #28a745;
        color: white;
    }

    .inbox-pagination .pages .page:hover:not(.active) {
        background-color: #e9ecef;
    }

    .inbox-pagination .btn-nav {
        background: none;
        border: none;
        cursor: pointer;
        color: #777;
        padding: 5px 10px;
    }

    .inbox-pagination .btn-nav:disabled {
        color: #ccc;
        cursor: not-allowed;
    }

    @media (max-width: 992px) {
        .inbox-container {
            flex-direction: column;
        }

        .inbox-messages-column,
        .inbox-details-column {
            width: 100%;
        }

        .inbox-details-column {
            border-top: 1px solid #e9ecef;
        }

        .detail-header-actions {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
            padding-top: 10px;
        }
    }

    @media (max-width: 768px) {
        .search-wrapper input {
            width: 130px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Actions Bar -->
    <div class="inbox-actions mb-2">
        <div>
            <button type="button" class="btn btn-sm btn-primary" id="btn-refresh">
                <i class="fa fa-refresh"></i> <?= $this->Dictionary->GetKeyword('Refresh'); ?>
            </button>
            <button type="button" class="btn btn-sm btn-default" id="btn-filter">
                <i class="fa fa-filter"></i> <?= $this->Dictionary->GetKeyword('Filter'); ?>
            </button>
            <button type="button" class="btn btn-sm btn-default" id="btn-toggle-column">
                <i class="fa fa-arrows-h"></i> <?= $this->Dictionary->GetKeyword('Toggle View'); ?>
            </button>
        </div>
        <div class="search-wrapper">
            <span class="ml-2 badge badge-primary" id="unread-counter">0</span> <?= $this->Dictionary->GetKeyword('Unread'); ?>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="inbox-filter-section mb-2" id="filter-section">
        <form id="filter-form" class="row">
            <!-- Code Filter -->
            <div class="col-md-4 mb-2">
                <label for="filter_import_code"><?= $this->Dictionary->GetKeyword('Code'); ?></label>
                <input type="text" class="form-control" id="filter_import_code" name="import_code">
            </div>
            <!-- Subject Filter -->
            <div class="col-md-4 mb-2">
                <label for="filter_import_book_subject"><?= $this->Dictionary->GetKeyword('Subject'); ?></label>
                <input type="text" class="form-control" id="filter_import_book_subject" name="import_book_subject">
            </div>
            <!-- From Department Filter -->
            <div class="col-md-4 mb-2">
                <label for="filter_import_from_department"><?= $this->Dictionary->GetKeyword('From Department'); ?></label>
                <input type="text" class="form-control" id="filter_import_from_department" name="import_from_department" onclick="OpenTree('department','filter_import_from_department','filter_import_from_department_id','1')" readonly>
                <input type="hidden" id="filter_import_from_department_id" name="import_from_department_id">
            </div>
            <!-- Filter Button -->
            <div class="col-md-12 mt-2 text-center">
                <button type="button" id="apply-filter" class="btn btn-sm btn-primary"><?= $this->Dictionary->GetKeyword('Apply Filter'); ?></button>
            </div>
        </form>
    </div>

    <div class="inbox-container">
        <!-- Messages Column (Left) -->
        <div class="inbox-messages-column">
            <!-- Message List -->
            <div class="inbox-message-list" id="inbox-message-list">
                <div class="inbox-loading">
                    <div class="inbox-spinner"></div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="inbox-pagination">
                <div>
                    <span id="showing-info"></span>
                </div>
                <div class="pages" id="pagination-container">
                    <!-- Pages will be dynamically generated -->
                </div>
                <div>
                    <button class="btn-nav" id="prev-page" disabled><i class="fa fa-chevron-left"></i></button>
                    <button class="btn-nav" id="next-page"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Details Column (Right) -->
        <div class="inbox-details-column">
            <div class="inbox-message-detail" id="inbox-message-detail">
                <div class="inbox-empty">
                    <i class="fa fa-envelope-o"></i>
                    <p><?= $this->Dictionary->GetKeyword('Select a message to view details'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables
    var inboxMessages = [];
    var currentPage = 0;
    var pageSize = 10;
    var totalRecords = 0;
    var totalPages = 0;
    var selectedMessageId = null;
    var searchQuery = '';
    var base_url = '<?= base_url(); ?>';

    // Wait for the document to be fully loaded with jQuery available
    document.addEventListener('DOMContentLoaded', function() {
        // Check if jQuery is available, if not wait for it
        var jQueryCheckInterval = setInterval(function() {
            if (window.jQuery) {
                clearInterval(jQueryCheckInterval);
                initializeInbox();
            }
        }, 100);
    });

    // Initialize the inbox once jQuery is available
    function initializeInbox() {
        // Load messages
        loadInboxMessages();

        // Event handlers
        $('#btn-refresh').on('click', function() {
            loadInboxMessages();
        });

        $('#btn-filter').on('click', function() {
            $('#filter-section').slideToggle();
        });

        $('#btn-toggle-column').on('click', function() {
            toggleLeftColumn();
        });

        $('#btn-back-to-list').on('click', function() {
            if ($('.inbox-container').hasClass('collapsed')) {
                toggleLeftColumn();
            }
        });

        $('#apply-filter').on('click', function() {
            currentPage = 0;
            loadInboxMessages();
        });

        $('#prev-page').on('click', function() {
            if (currentPage > 0) {
                currentPage--;
                loadInboxMessages();
            }
        });

        $('#next-page').on('click', function() {
            if (currentPage < totalPages - 1) {
                currentPage++;
                loadInboxMessages();
            }
        });
    }

    // Load messages from server
    function loadInboxMessages() {
        // Show loading state
        $('#inbox-message-list').html('<div class="inbox-loading"><div class="inbox-spinner"></div></div>');

        // Get filter values
        var filterData = {
            import_code: $('#filter_import_code').val(),
            import_from_department_id: $('#filter_import_from_department_id').val(),
            import_book_subject: $('#filter_import_book_subject').val(),
            start: currentPage * pageSize,
            length: pageSize,
            draw: 1,
            order: [{"column": 0, "dir": "desc"}] // Order by date descending
        };

        // Make AJAX request
        $.ajax({
            url: '<?= $ajax_url ?>',
            type: 'POST',
            data: filterData,
            dataType: 'json',
            success: function(response) {
                // Update pagination
                totalRecords = response.recordsTotal;
                totalPages = Math.ceil(totalRecords / pageSize);
                updatePagination();

                // Update showing info
                $('#showing-info').text('<?= $this->Dictionary->GetKeyword("Showing"); ?> ' +
                    (currentPage * pageSize + 1) + ' - ' +
                    Math.min((currentPage + 1) * pageSize, totalRecords) +
                    ' <?= $this->Dictionary->GetKeyword("of"); ?> ' + totalRecords);

                // Process messages
                processMessages(response.data, response.notFoundMessageData);

                // Update unread counter after processing messages
                updateUnreadCounter();
            },
            error: function(xhr, status, error) {
                console.error('Error loading messages:', error);
                $('#inbox-message-list').html(`
                <div class="inbox-empty">
                    <i class="fa fa-exclamation-circle"></i>
                    <p><?= $this->Dictionary->GetKeyword("Error loading messages"); ?></p>
                </div>
            `);
            }
        });
    }

    // Process messages from API response
    function processMessages(data, notFoundMessageData) {
        // Clear message list
        $('#inbox-message-list').empty();

        console.log('notFoundMessageData',notFoundMessageData);
        if(notFoundMessageData.length > 0 ){

            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "<?= $this->Dictionary->GetKeyword("The code exists in"); ?>" + ' '  +  notFoundMessageData[1] ,
                footer: '<a href="' + '<?= base_url('Inbox/List/') ?>' + notFoundMessageData[0] + '"> <?= $this->Dictionary->GetKeyword("Go To Related Code?"); ?></a>'

            });
            //     $('#inbox-message-list').html(`
            //     <div class="inbox-empty">
            //         <i class="fa fa-envelope-o"></i>
            //         <p>${notFoundMessageData[1]}</p>
            //     </div>
            // `);
            //     return;
        }
        // If no messages
        if (data.length === 0) {
            $('#inbox-message-list').html(`
            <div class="inbox-empty">
                <i class="fa fa-envelope-o"></i>
                <p><?= $this->Dictionary->GetKeyword("No messages found"); ?></p>
            </div>
        `);
            return;
        }

        // Reset messages array
        inboxMessages = [];

        console.log('dataaaaaa', data);
        // Loop through the data and create message items
        for (var i = 0; i < data.length; i++) {
            var message = {
                id: data[i].import_id,
                code: data[i].import_code,
                from: data[i].import_from_department,
                subject: data[i].import_book_subject,
                //date: data[i].import_received_date,
                date: data[i].import_trace_sent_date,
                actions: data[i].Actions,
                trace_type: data[i].import_trace_type_name,
                trace_icon: data[i].import_trace_type_icon,
                trace_status: data[i].import_trace_status_name,
                trace_status_icon: data[i].import_trace_status_icon,
                selected_trace_type_id: data[i].selected_trace_type_id,
                // Randomly set some messages as unread for demonstration
                // In a real app, you'd get this from the server
                unread: data[i].import_trace_is_read == 0,
                last_trace_sender_department: data[i].last_trace_sender_department,
                last_trace_sender_user: data[i].last_trace_sender_user

            };


            inboxMessages.push(message);

            // Create message element
            var $message = $(`
            <div class="inbox-message ${message.unread ? 'unread' : ''}" data-id="${message.id}" data-trace="${message.selected_trace_type_id}">
                <div class="inbox-message-indicator"></div>
                <div class="inbox-message-content">
                    <div class="inbox-message-from">${message.from}</div>
                    <div class="inbox-message-subject">${message.subject}</div>
                    <div class="inbox-message-preview">Code: ${message.code}</div>
                   <div class="inbox-message-from">  ${message.last_trace_sender_user} <i class="fa fa-user"></i> / ${message.last_trace_sender_department}</div>
                </div>

                <div class="inbox-message-icons">
                    <i class="${message.trace_icon}" title="${message.trace_type}"></i>
                </div>
                <div class="inbox-message-date">
                    ${message.date}
                </div>
            </div>
        `);

            // Message click event
            $message.on('click', function(e) {
                var messageId = $(this).data('id');
                var traceType =  $(this).data('trace');
                selectMessage(messageId, traceType);
            });

            // Add message to list
            $('#inbox-message-list').append($message);
        }
    }

    // Update pagination controls
    function updatePagination() {
        // Enable/disable prev/next buttons
        $('#prev-page').prop('disabled', currentPage === 0);
        $('#next-page').prop('disabled', currentPage >= totalPages - 1);

        // Generate pagination links
        var $paginationContainer = $('#pagination-container');
        $paginationContainer.empty();

        // Maximum number of page links to show
        var maxPages = 5;
        var startPage = Math.max(0, Math.min(currentPage - Math.floor(maxPages / 2), totalPages - maxPages));
        var endPage = Math.min(startPage + maxPages, totalPages);

        // Add pagination links
        for (var i = startPage; i < endPage; i++) {
            var $page = $(`<div class="page ${i === currentPage ? 'active' : ''}">${i + 1}</div>`);

            $page.on('click', function() {
                currentPage = parseInt($(this).text()) - 1;
                loadInboxMessages();
            });

            $paginationContainer.append($page);
        }
    }

    // Select a message to display details
    function selectMessage(messageId, traceType) {
        // Remove active class from all messages and add to clicked one
        $('.inbox-message').removeClass('active');
        $('.inbox-message[data-id="' + messageId + '"]').addClass('active');

        // Mark as read if necessary
        if ($('.inbox-message[data-id="' + messageId + '"]').hasClass('unread')) {
            $('.inbox-message[data-id="' + messageId + '"]').removeClass('unread');

            // Update unread status in our data
            for (let i = 0; i < inboxMessages.length; i++) {
                if (inboxMessages[i].id == messageId) {
                    inboxMessages[i].unread = false;
                    break;
                }
            }

            // Update unread counter
            updateUnreadCounter();
        }

        // Show loading state
        $('.inbox-details-column').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading message details...</p></div>');

        // On mobile or small screens, auto-collapse the left column
        if (window.innerWidth < 992) {
            if (!$('.inbox-container').hasClass('collapsed')) {
                toggleLeftColumn();
            }
        }

        // Get message details via AJAX
        let message = inboxMessages.find(m => m.id == messageId);
        if (message) {
            // Determine the controller based on message type
            let controller = 'Import';

            // AJAX call to get the message details
            $.ajax({
                url: base_url + controller + '/AjaxDetails/' + messageId + '/' + traceType,
                type: 'GET',
                success: function(response) {
                    // Display the response directly in the details column
                    $('.inbox-details-column').html(response);
                },
                error: function() {
                    $('.inbox-details-column').html('<div class="alert alert-danger">Failed to load message details.</div>');
                }
            });
        }
    }

    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return '';

        var date = new Date(dateString);

        // Check if date is valid
        if (isNaN(date.getTime())) {
            return dateString;
        }

        var now = new Date();
        var diff = now - date;
        var oneDay = 24 * 60 * 60 * 1000;

        // If date is today, display time only
        if (diff < oneDay && date.getDate() === now.getDate()) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }

        // If date is this year, display date without year
        if (date.getFullYear() === now.getFullYear()) {
            return date.toLocaleDateString([], {month: 'short', day: 'numeric'});
        }

        // Otherwise show full date
        return date.toLocaleDateString([], {year: 'numeric', month: 'short', day: 'numeric'});
    }

    // Make the refresh function available globally
    window.refresh = function() {
        if (window.jQuery) {
            loadInboxMessages();
        } else {
            console.warn('jQuery not loaded yet. Refresh will be delayed.');
            setTimeout(function() {
                window.refresh();
            }, 100);
        }
    }

    // Toggle left column
    function toggleLeftColumn() {
        $('.inbox-container').toggleClass('collapsed');

        // Change icon based on state
        if ($('.inbox-container').hasClass('collapsed')) {
            $('#btn-toggle-column i').removeClass('fa-arrows-h').addClass('fa-list');
        } else {
            $('#btn-toggle-column i').removeClass('fa-list').addClass('fa-arrows-h');
        }
    }

    // Update unread messages counter
    function updateUnreadCounter() {
        let unreadCount = 0;

        // Count unread messages
        for (let i = 0; i < inboxMessages.length; i++) {
            if (inboxMessages[i].unread) {
                unreadCount++;
            }
        }

        // Update counter
        $('#unread-counter').text(unreadCount);
    }
</script>