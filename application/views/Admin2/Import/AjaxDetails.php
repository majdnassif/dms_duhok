<?php
/**
 * Simplified Import Details view for AJAX loading
 * Used by the inbox to show document details in the panel
 */
?>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 20px;
        margin-right: 10px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #337ab7;
    }

    input:checked + .slider:before {
        transform: translateX(14px);
    }


    .inbox-detail-wrapper {
        padding: 10px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .inbox-detail-header {
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 15px;
    }
    .inbox-detail-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .inbox-detail-subject {
        font-size: 18px;
        font-weight: 600;
    }
    .inbox-detail-user {
        color: #555;
        font-size: 14px;
    }
    .inbox-detail-meta {
        display: flex;
        justify-content: space-between;
        color: #777;
        font-size: 13px;
    }
    .inbox-detail-body {
        padding: 0;
    }
    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .panel-heading {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .panel-title {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 16px;
        color: inherit;
    }
    .panel-body {
        padding: 15px;
    }
    .panel-default > .panel-heading {
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
    }
    .panel-info > .panel-heading {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
    }
    .panel-primary > .panel-heading {
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
    }
    .table-sm th, .table-sm td {
        padding: 0.5rem;
    }
    .attachment-link {
        float: right;
    }
    .mt-3 {
        margin-top: 15px;
    }
    /* Improved Trace timeline styling */
    .trace-timeline {
        position: relative;
        padding: 0;
        margin: 0;
    }
    .trace-item {
        display: flex;
        position: relative;
        padding: 0;
        border-left: 4px solid #337ab7;
        margin-bottom: 0;
        background-color: transparent;
    }
    .trace-item-even {
        background-color: rgba(242, 242, 242, 0.5);
    }
    .trace-item-odd {
        background-color: #ffffff;
    }
    .trace-index {
        width: 60px;
        text-align: center;
        padding: 15px 0;
        position: relative;
    }
    .trace-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        background-color: #337ab7;
        color: #fff;
        font-weight: bold;
        z-index: 2;
        position: relative;
    }
    .trace-line {
        position: absolute;
        top: 45px;
        bottom: 0;
        left: 30px;
        width: 2px;
        background-color: #ddd;
        z-index: 1;
    }
    .trace-item:last-child .trace-line {
        display: none;
    }
    .trace-content {
        flex: 1;
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    .trace-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .trace-route {
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }
    .trace-from, .trace-to {
        display: inline-block;
        padding: 3px 8px;
        background-color: #f8f9fa;
        border-radius: 3px;
        border: 1px solid #eee;
    }
    .trace-details {
        margin-bottom: 15px;
    }
    .trace-note {
        background-color: #fff;
        padding: 10px;
        border-radius: 3px;
        margin-bottom: 10px;
        border: 1px solid #e3e3e3;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .trace-note-header {
        font-weight: bold;
        margin-bottom: 5px;
        color: #666;
    }
    .trace-note-content {
        padding: 5px;
        color: #333;
        white-space: pre-line;
    }
    .trace-attachments {
        margin-top: 10px;
    }
    .trace-attachments-header {
        font-weight: bold;
        margin-bottom: 5px;
        color: #666;
    }
    .trace-attachments-list {
        list-style: none;
        padding-left: 5px;
        margin-bottom: 0;
    }
    .trace-attachments-list li {
        padding: 3px 0;
    }
    .trace-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
    }
    .trace-metadata {
        display: flex;
        gap: 10px;
    }
    .trace-user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .trace-user {
        color: #666;
        font-size: 13px;
    }
    .trace-date {
        color: #666;
        font-size: 13px;
    }
    .p-0 {
        padding: 0 !important;
    }
    .attachment-link {
        display: inline-block;
        padding: 2px 5px;
        border-radius: 3px;
        text-decoration: none;
        color: #337ab7;
    }
    .attachment-link:hover {
        background-color: #f5f5f5;
        text-decoration: none;
    }

    /* Book Details Section Styling */
    .book-details-panel {
        border: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .book-details-panel .panel-heading {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eaeaea;
        padding: 8px 12px;
    }

    .book-details-panel .panel-title {
        font-size: 15px;
        font-weight: 600;
        color: #444;
    }

    .book-details-compact {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: -5px;
    }

    .book-detail-row {
        flex: 0 0 calc(33.333% - 8px);
        min-width: 180px;
        padding: 6px 8px;
        border-bottom: 1px solid #f0f0f0;
    }

    .book-detail-label {
        font-size: 12px;
        color: #777;
        margin-bottom: 2px;
        font-weight: 500;
    }

    .book-detail-value {
        font-size: 13px;
        color: #333;
        word-break: break-word;
    }

    .priority-high, .priority-urgent {
        color: #d9534f;
        font-weight: bold;
    }

    .priority-medium {
        color: #f0ad4e;
    }

    .priority-low, .priority-normal {
        color: #5cb85c;
    }
    /* Unread and read trace card styling */
    .trace-card-unread {
        background-color: #f8f9ff;
        border-left: 4px solid #f0ad4e;
    }

    .trace-card-read {
        border-left: 4px solid #5cb85c;
    }

    .trace-card-unread .trace-card-header {
        background-color: #f0f8ff;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .book-details-compact {
            flex-direction: column;
        }

        .book-detail-row {
            flex: 0 0 100%;
        }
    }
    /* for big screen */
    @media (min-width: 1200px) {
        .book-details-compact {
            flex-direction: row;
        }
        .book-detail-row {
            flex: 0 0 calc(25% - 8px);
        }
    }

    /* Attachments Section Styling */
    .attachment-panel {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .attachment-panel .panel-heading {
        background-color: #d9edf7;
        border-bottom: 1px solid #bce8f1;
    }

    .attachment-panel .panel-title {
        font-size: 16px;
        font-weight: 600;
        color: #31708f;
    }

    .attachment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .attachment-item {
        display: flex;
        background-color: #ffffff;
        border-radius: 4px;
        padding: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e7f3f9;
        transition: all 0.2s ease;
    }

    .attachment-item:hover {
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #bce8f1;
    }

    .attachment-icon {
        position: relative;
        width: 46px;
        height: 60px;
        background-color: #f8f9fa;
        color: #5bc0de;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 24px;
        border-radius: 3px;
        border: 1px solid #eaeaea;
    }

    .attachment-ext {
        position: absolute;
        bottom: 3px;
        font-size: 9px;
        font-weight: bold;
        color: #666;
        text-transform: uppercase;
    }

    .attachment-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .attachment-name {
        font-size: 14px;
        color: #333;
        margin-bottom: 10px;
        word-break: break-word;
        max-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .attachment-actions {
        display: flex;
        justify-content: flex-end;
    }

    .attachment-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        margin-left: 8px;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .view-btn {
        background-color: #5bc0de;
    }

    .view-btn:hover {
        background-color: #31b0d5;
        color: #fff;
        text-decoration: none;
    }

    .download-btn {
        background-color: #5cb85c;
    }

    .download-btn:hover {
        background-color: #449d44;
        color: #fff;
        text-decoration: none;
    }

    /* Responsive adjustments for attachments */
    @media (max-width: 768px) {
        .attachment-grid {
            grid-template-columns: 1fr;
        }
    }

    .answer-panel {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .answer-panel .panel-heading {
        background-color: #4ea121;
        border-bottom: 1px solid #4ea121;
    }

    .answer-panel .panel-title {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
    }

    /* Completely redesigned Trace History Section */
    .trace-panel {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .trace-panel .panel-heading {
        background-color: #337ab7;
        border-bottom: 1px solid #2e6da4;
    }

    .trace-panel .panel-title {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
    }

    .trace-flow-container {
        display: flex;
        flex-direction: column;
    }

    /* Top flow path styling */
    .trace-flow-path {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        background-color: #f7f9fc;
        border-bottom: 1px solid #e9ecef;
    }

    .trace-flow-node {
        position: relative;
        cursor: pointer;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 60px;
    }

    .trace-flow-dot {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: #337ab7;
        transition: all 0.3s ease;
    }

    .trace-flow-date {
        font-size: 10px;
        color: #666;
        margin-top: 5px;
        text-align: center;
        white-space: nowrap;
        font-weight: 600;
    }

    .trace-flow-node.node-unread .trace-flow-dot {
        background-color: #f0ad4e;
    }

    .trace-flow-status-indicator {
        position: absolute;
        top: -8px;
        right: 15px;
        background-color: #fff;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .trace-flow-connector {
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, #337ab7, #337ab7);
        margin: 0 5px;
        position: relative;
        z-index: 1;
    }

    .status-pending {
        color: #f0ad4e;
    }

    .status-completed {
        color: #5cb85c;
    }

    .status-rejected {
        color: #d9534f;
    }

    .status-unknown {
        color: #777;
    }

    /* Trace detail cards */
    .trace-details-container {
        padding: 15px;
    }

    .trace-card {
        background-color: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        border-left: 4px solid #337ab7;
    }

    .trace-card:hover {
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    /* Unread and read trace card styling */
    .trace-card-unread {
        background-color: #f8f9ff;
        border-left: 4px solid #f0ad4e;
    }

    .trace-card-read {
        border-left: 4px solid #5cb85c;
    }

    .trace-card-unread .trace-card-header {
        background-color: #f0f8ff;
    }

    /* Updated styles for collapsible trace cards */
    .trace-card-header {
        display: flex;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .trace-card-collapsed .trace-card-header {
        border-bottom: none;
    }

    .trace-card-collapsed {
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .trace-card-collapsed:hover {
        box-shadow: 0 2px 5px rgba(0,0,0,0.12);
        transform: translateY(-1px);
    }

    .trace-card-expanded:hover {
        transform: translateY(-2px);
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    .trace-card-collapsed .toggle-icon .fa {
        transform: rotate(-90deg);
    }

    .trace-card-number {
        font-weight: bold;
        font-size: 14px;
        color: #495057;
    }

    .trace-type-badge {
        background-color: #337ab7;
        color: #fff;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        color: #fff;
    }

    .status-badge.status-pending {
        background-color: #f0ad4e;
    }

    .status-badge.status-completed {
        background-color: #5cb85c;
    }

    .status-badge.status-rejected {
        background-color: #d9534f;
    }

    .trace-card-body {
        padding: 15px;
    }

    .trace-card-route {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e9ecef;
    }

    .trace-card-department {
        flex: 1;
    }


    .department-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .department-name {
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 4px;
    }

    .department-user {
        font-size: 12px;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        gap: 10px;
    }

    .trace-direction-arrow {
        padding: 0 15px;
        color: #6c757d;
        font-size: 18px;
    }

    .trace-card-date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        color: #6c757d;
        font-size: 13px;
    }

    .trace-read-indicator {
        margin-left: 10px;
    }

    .trace-card-note {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding: 12px;
        margin-bottom: 15px;
    }

    .trace-note-header {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .trace-note-content {
        color: #212529;
        font-size: 14px;
        line-height: 1.5;
        white-space: pre-line;
    }

    .trace-card-attachments {
        margin-top: 15px;
    }

    .trace-attachments-header {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .trace-attachments-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .trace-attachment-item {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 6px 10px;
        flex-grow: 1;
        max-width: calc(50% - 5px);
    }

    .trace-attachment-link {
        display: flex;
        align-items: center;
        color: #337ab7;
        text-decoration: none;
        font-size: 13px;
        overflow: hidden;
        white-space: nowrap;
    }

    .trace-attachment-link:hover {
        color: #23527c;
        text-decoration: none;
    }

    .trace-attachment-link i {
        margin-right: 6px;
        font-size: 16px;
    }

    .trace-attachment-link .file-name {
        text-overflow: ellipsis;
        overflow: hidden;
    }

    /* Add interactive JS */
    @media (max-width: 768px) {
        .trace-flow-path {
            display: none; /* Hide flow path on mobile to save space */
        }

        .trace-attachment-item {
            max-width: 100%;
        }

        .trace-card-route {
            flex-direction: column;
            align-items: flex-start;
        }

        .trace-card-department.sender,
        .trace-card-department.receiver {
            /*text-align: left;*/
            margin-bottom: 10px;
        }

        .trace-direction-arrow {
            transform: rotate(90deg);
            margin: 10px 0;
        }
    }

    .trace-attachments-empty {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 4px;
        color: #6c757d;
    }

    .no-attachments-message {
        font-size: 13px;
    }

    .add-attachment-btn {
        font-size: 12px;
        padding: 3px 8px;
        background-color: #fff;
        border-color: #ced4da;
        transition: all 0.2s ease;
    }

    .add-attachment-btn:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
    }

    /* Highlight animation for trace cards */
    @keyframes highlight-pulse {
        0% { box-shadow: 0 0 0 0 rgba(51, 122, 183, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(51, 122, 183, 0); }
        100% { box-shadow: 0 0 0 0 rgba(51, 122, 183, 0); }
    }

    .highlight-card {
        animation: highlight-pulse 1.5s ease-out;
    }

    .trace_type_icon, .trace_status_icon {
        margin-left: 5px;
    }
    .inbox-detail-header-actions {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .assigntome-loading {
        display: none;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 30px;
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        text-align: center;
        color: #fff;
    }




    <?php if($this->UserModel->language()!="ENGLISH"){?>
    .trace-card-department.sender {
        text-align: right ;
    }

    .trace-card-department.receiver {
        text-align: left;
    }
    <?php }else{?>
    .trace-card-department.sender {
        text-align: left;
    }
    .trace-card-department.receiver {
        text-align: right;
    }
    <?php } ?>

</style>


<div class="inbox-detail-wrapper">
    <!-- Updated header with username and import date -->
    <div class="inbox-detail-header">

        <?php
        $can_add_normal_trace = $this->Permission->CheckPermissionOperation('import_addtrace');
        $can_add_out_trace = $this->Permission->CheckPermissionOperation('out_add');
        if(
            ($can_add_normal_trace || $can_add_out_trace)
            && $selected_trace_type != 1 // do not show actions for send trace
            && $selected_trace_type != 4 // do not show actions for out trace

        ):?>

            <div class="inbox-detail-header-actions">

                <?php if($last_trace_id && !$is_assigned_to_me): ?>
                    <div class="checkbox switchCheckAssignedClass" style="display: flex; align-items: center;">
                        <label for="switchCheckAssigned" class="switch" style="margin-right: 10px;">
                            <input type="checkbox" id="switchCheckAssigned">
                            <span class="slider round"></span>
                        </label>
                        <span class="assign-span"><strong><?= $this->Dictionary->GetKeyword('Assigned To Me'); ?></strong></span>
                    </div>
                <?php endif; ?>

                <div class="text-center p-5 assigntome-loading">
                    <div class="overlay-icon">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <p class="mt-2">Assigning...</p>
                </div>

                <?php if( ($last_trace_id && $is_assigned_to_me ) || !$last_trace_id): ?>
                    <div class="text-center">

                        <?php  if($can_add_normal_trace): ?>

                            <?php if($last_trace_type != 3): ?>
                                <button type="button" class="btn btn-sm btn-primary btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="3" data-status="1">
                                    <i class="fa fa-archive"></i> <?= $this->Dictionary->GetKeyword('Archive'); ?>
                                </button>
                            <?php endif; ?>

                            <?php if($last_trace_type != 6): ?>
                                <button type="button" class="btn btn-sm btn-info btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="6" data-status="1">
                                    <i class="fa fa-gears"></i> <?= $this->Dictionary->GetKeyword('In Progress'); ?>
                                </button>
                            <?php endif; ?>

                            <?php if($last_trace_type != 2): ?>
                                <button type="button" class="btn btn-sm btn-warning btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="2" data-status="1">
                                    <i class="fa fa-ban"></i> <?= $this->Dictionary->GetKeyword('Suspend'); ?>
                                </button>
                            <?php endif; ?>


                            <button type="button" class="btn btn-sm btn-primary btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="5" data-status="1">
                                <i class="fa fa-arrows-h"></i> <?= $this->Dictionary->GetKeyword('Move To Action'); ?>
                            </button>

                            <button type="button" class="btn btn-sm btn-success btn-self-trace-sent"  data-toggle="modal" data-target="#addTraceModalSent" data-type="1" data-status="1">
                                <i class="fa fa-mail-forward"></i> <?= $this->Dictionary->GetKeyword('Sent To Action'); ?>
                            </button>



                            <button type="button" class="btn btn-sm btn-primary btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="7" data-status="1">
                                <i class="fa fa-question"></i> <?= $this->Dictionary->GetKeyword('Consult'); ?>
                            </button>

                        <?php endif; ?>

                        <?php  if($can_add_out_trace): ?>

                            <button type="button" class="btn btn-sm btn-danger btn-self-trace"  data-toggle="modal" data-target="#addTraceModalOut" data-type="4" data-status="1">
                                <i class="fa fa-upload"></i> <?= $this->Dictionary->GetKeyword('Out Action'); ?>
                            </button>

                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if($last_trace_id && $is_assigned_to_me && $last_trace_is_read ): ?>
                    <div class="checkbox"  style="display: flex; align-items: center;">
                        <span class="read-span"><strong><?= $this->Dictionary->GetKeyword('Mark As Unread'); ?></strong> </span>

                        <label for="switchCheckRead" class="switch" style="margin-left: 10px;">
                            <input type="checkbox" id="switchCheckRead" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                <?php endif; ?>

            </div>

        <?php  endif; ?>


        <div class="inbox-detail-top">
            <div class="inbox-detail-subject"><strong><?= $this->Dictionary->GetKeyword('Subject'); ?>:</strong> <?= $import['import_book_subject']; ?></div>

            <!--            --><?php //if( ($last_trace_id && $is_assigned_to_me ) || !$last_trace_id): ?>
            <!--                <div class="row mb-2 text-center">-->
            <!--                    --><?php //if($last_trace_type != 5): ?>
            <!--                        <button type="button" class="btn btn-sm btn-primary btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="5" data-status="3">-->
            <!--                            <i class="fa fa-archive"></i> --><?php //= $this->Dictionary->GetKeyword('Archive'); ?>
            <!--                        </button>-->
            <!--                    --><?php //endif; ?>
            <!---->
            <!--                    --><?php //if($last_trace_type != 2): ?>
            <!--                        <button type="button" class="btn btn-sm btn-info btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="2" data-status="1">-->
            <!--                            <i class="fa fa-gears"></i> --><?php //= $this->Dictionary->GetKeyword('In Progress'); ?>
            <!--                        </button>-->
            <!--                    --><?php //endif; ?>
            <!---->
            <!--                    --><?php //if($last_trace_type != 3): ?>
            <!--                        <button type="button" class="btn btn-sm btn-warning btn-self-trace"  data-toggle="modal" data-target="#addTraceModal" data-type="3" data-status="4">-->
            <!--                            <i class="fa fa-ban"></i> --><?php //= $this->Dictionary->GetKeyword('Suspend'); ?>
            <!--                        </button>-->
            <!--                    --><?php //endif; ?>
            <!---->
            <!--                    <button type="button" class="btn btn-sm btn-success btn-self-trace-sent"  data-toggle="modal" data-target="#addTraceModalSent" data-type="1">-->
            <!--                        <i class="fa fa-cloud-upload"></i> --><?php //= $this->Dictionary->GetKeyword('Sent To'); ?>
            <!--                    </button>-->
            <!---->
            <!--                    <button type="button" class="btn btn-sm btn-danger btn-self-trace"  data-toggle="modal" data-target="#addTraceModalOut" data-type="6" data-status="6">-->
            <!--                        <i class="fa fa-send-o"></i> --><?php //= $this->Dictionary->GetKeyword('Out'); ?>
            <!--                    </button>-->
            <!--                </div>-->
            <!--            --><?php //endif; ?>



            <div class="inbox-detail-user">
                <strong><?= $this->Dictionary->GetKeyword('User'); ?>:</strong> <?= isset($import['created_by_name']) ? $import['created_by_name'] : ''; ?>
            </div>

        </div>

        <div class="inbox-detail-meta">
            <div>
                <strong><?= $this->Dictionary->GetKeyword('From'); ?>:</strong> <?= $import['import_from_department']; ?>
            </div>

            <div >
                <strong><?= $this->Dictionary->GetKeyword('Book Number'); ?>:</strong> <?= $import['import_book_number']; ?>
            </div>

            <div>
                <strong><?= $this->Dictionary->GetKeyword('Date'); ?>:</strong> <?= date('Y-m-d', strtotime($import['import_book_date'])); ?>
            </div>
        </div>
    </div>

    <div class="inbox-detail-body">
        <!-- Redesigned Book details section with compact layout -->
        <div class="panel panel-default book-details-panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Book Details'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="book-details-compact">
                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Import Code'); ?></div>
                        <div class="book-detail-value"><?= $import['import_code']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Number'); ?></div>
                        <div class="book-detail-value"><?= $import['import_book_number']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Date'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_book_date'] ? date('Y-m-d', strtotime($import['import_book_date'])) : '-'; ?>
                        </div>
                    </div>

                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Subject'); ?></div>
                        <div class="book-detail-value"><?= $import['import_book_subject']; ?></div>
                    </div>

                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Received Date'); ?></div>
                        <div class="book-detail-value"><?= $import['import_received_date']; ?></div>
                    </div>


                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Incoming Number'); ?></div>
                        <div class="book-detail-value"><?= $import['import_incoming_number']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('From Department'); ?></div>
                        <div class="book-detail-value"><?= $import['import_from_department']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('To Department'); ?></div>
                        <div class="book-detail-value"><?= $import['import_to_department']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Created By'); ?></div>
                        <div class="book-detail-value"><?= $import['created_by_name']; ?></div>
                    </div>



                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Created Date'); ?></div>
                        <div class="book-detail-value"><?= $import['import_created_at']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Signed By'); ?></div>
                        <div class="book-detail-value"><?= $import['import_signed_by']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Is Direct'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_is_direct'] == 1 ? '<span class="status-badge status-completed">' . $this->Dictionary->GetKeyword('Yes') .'</span>'  : '<span class="status-badge status-pending">' . $this->Dictionary->GetKeyword('No') .'</span>'; ?>
                        </div>

                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Is Answer'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_is_answer'] == 1 ? '<span class="status-badge status-completed">' . $this->Dictionary->GetKeyword('Yes') .'</span>'  : '<span class="status-badge status-pending">' . $this->Dictionary->GetKeyword('No') .'</span>'; ?>

                        </div>
                    </div>

                    <?php if (isset($import['import_book_category'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Category'); ?></div>
                            <div class="book-detail-value"><?= $import['import_book_category']; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($import['import_book_language'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Language'); ?></div>
                            <div class="book-detail-value"><?= $this->Dictionary->GetKeyword($import['import_book_language']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($import['import_book_importance_level'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Importance Level'); ?></div>
                            <div class="book-detail-value"><?= $this->Dictionary->GetKeyword($import['import_book_importance_level']); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(!empty($last_trace)): ?>
            <div class="panel panel-default book-details-panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Last Trace Brief'); ?></h3>
                    <div style="display: flex;justify-content: center;">

                        <?php if(isset($last_trace['action_type_name']) && !empty($last_trace['action_type_name'])): ?>
                            <div class="trace-card-type" style="margin: 0 10px">
                                <span> #</span>
                                <span class="status-badge status-pending"
                                      data-toggle="tooltip"
                                      data-title="<?= $this->Dictionary->GetKeyword('Action'); ?>"
                                      data-placement="bottom"
                                ><?= isset($last_trace['action_type_name'])  ?  $this->Dictionary->GetKeyword($last_trace['action_type_name'] ) : ''  ?>
                        </span>
                            </div>
                        <?php endif; ?>


                        <div class="trace-card-type" style="margin: 0 10px">
                            <span> <i class="<?= $last_trace['import_trace_type_icon']; ?> trace_type_icon"></i></span>
                            <span class="trace-type-badge"
                                  data-toggle="tooltip"
                                  data-title="<?= $this->Dictionary->GetKeyword('type'); ?>"
                                  data-placement="bottom"
                            ><?=  $this->Dictionary->GetKeyword($last_trace['import_trace_type_name'] ); ?>
                        </span>
                        </div>

                        <div class="trace-card-status"
                             data-toggle="tooltip"
                             data-title="<?= $this->Dictionary->GetKeyword('status'); ?>"
                             data-placement="bottom"
                        >
                            <i class="<?= $last_trace['import_trace_status_icon']; ?> trace_status_icon"></i>
                            <span class="status-badge status-pending" style="background-color: #ee4ef0">
                            <?php  echo $this->Dictionary->GetKeyword($last_trace['import_trace_status_name'] ?? '');
                            if($last_trace['import_trace_status_id'] == 3) {
                                ?>
                                <span><i class="fa fa-calendar"></i> <?=  ( isset($last_trace['import_trace_close_date']) && !empty($last_trace['import_trace_close_date'])) ? date('Y-m-d', strtotime($last_trace['import_trace_close_date'])) : ''; ?></span>
                            <?php } ?>

                        </span>
                        </div>

                    </div>
                </div>

            </div>
        <?php endif; ?>

        <?php if (!empty($import['import_note'])): ?>
            <div class="panel panel-info mt-3">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Notes'); ?></h3>
                </div>
                <div class="panel-body">
                    <?= nl2br($import['import_note']); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($import['import_attachment'])): ?>
            <div class="panel panel-info mt-3 attachment-panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-paperclip"></i> <?= $this->Dictionary->GetKeyword('Attachments'); ?> (<?= count($import['import_attachment']); ?>)</h3>
                </div>
                <div class="panel-body">
                    <div class="attachment-grid">
                        <?php foreach ($import['import_attachment'] as $attachment): ?>
                            <?php
                            $fileExtension = pathinfo($attachment['original_name'], PATHINFO_EXTENSION);
                            $fileIcon = 'fa-file-o';

                            // Determine file icon based on extension
                            if (in_array(strtolower($fileExtension), ['pdf'])) {
                                $fileIcon = 'fa-file-pdf-o';
                            } elseif (in_array(strtolower($fileExtension), ['doc', 'docx', 'rtf', 'txt'])) {
                                $fileIcon = 'fa-file-text-o';
                            } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx', 'csv'])) {
                                $fileIcon = 'fa-file-excel-o';
                            } elseif (in_array(strtolower($fileExtension), ['ppt', 'pptx'])) {
                                $fileIcon = 'fa-file-powerpoint-o';
                            } elseif (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])) {
                                $fileIcon = 'fa-file-image-o';
                            } elseif (in_array(strtolower($fileExtension), ['zip', 'rar', '7z', 'tar', 'gz'])) {
                                $fileIcon = 'fa-file-archive-o';
                            }
                            ?>
                            <div class="attachment-item">
                                <div class="attachment-icon">
                                    <i class="fa <?= $fileIcon; ?>"></i>
                                    <span class="attachment-ext"><?= strtoupper($fileExtension); ?></span>
                                </div>
                                <div class="attachment-details">
                                    <div class="attachment-name" title="<?= $attachment['original_name']; ?>"><?= $attachment['original_name']; ?></div>
                                    <div class="attachment-actions">
                                        <a href="<?= base_url($attachment['file_path']); ?>" class="attachment-action-btn view-btn" target="_blank" title="<?= $this->Dictionary->GetKeyword('View'); ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url($attachment['file_path']); ?>" class="attachment-action-btn download-btn" download title="<?= $this->Dictionary->GetKeyword('Download'); ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Completely redesigned Trace History section with a modern interactive flow -->
        <?php if (isset($import_traces) && !empty($import_traces)): ?>
            <div class="panel panel-primary mt-3 trace-panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-history"></i> <?= $this->Dictionary->GetKeyword('Trace History'); ?> (<?= count($import_traces); ?>)</h3>
                </div>
                <div class="panel-body p-0">
                    <div class="trace-flow-container">
                        <!-- Top trace path visualization -->
                        <div class="trace-flow-path">
                            <?php foreach ($import_traces as $index => $trace): ?>
                                <div class="trace-flow-node <?= isset($trace['import_trace_is_read']) && $trace['import_trace_is_read'] ? 'node-read' : 'node-unread'; ?>"
                                     data-trace-index="<?= $index; ?>"
                                     data-trace-id="<?= $trace['import_trace_id']; ?>"
                                     data-toggle="tooltip"
                                     title="<?= $trace['sender_department']; ?> → <?= $trace['receiver_department']; ?> (<?= isset($trace['import_trace_sent_date']) ? date('Y-m-d', strtotime($trace['import_trace_sent_date'])) : ''; ?>)"
                                >
                                    <div class="trace-flow-dot" style="text-align: center;">
                                        <i class="<?= $trace['import_trace_type_icon']; ?>" style=" color: #f9f5f7; margin-top: 6px;"></i>
                                    </div>
                                    <div class="trace-flow-status-indicator">

                                        <?php if ($trace['import_trace_is_read'] == 0): ?>
                                            <i class="fa fa-clock-o status-pending"></i>
                                        <?php else: ?>
                                            <i class="fa fa-check status-completed"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="trace-flow-date">
                                        <?= isset($trace['import_trace_sent_date']) ? date('d/m', strtotime($trace['import_trace_sent_date'])) : ''; ?>
                                    </div>
                                </div>
                                <?php if ($index < count($import_traces) - 1): ?>
                                    <div class="trace-flow-connector"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Trace details cards -->
                        <div class="trace-details-container">
                            <?php
                            foreach ($import_traces as $index => $trace):
                                // Determine if this trace should be expanded by default (only the most recent ones)
                                $isRecent = ($index == 0); // Show the most recent 1 traces expanded
                                $expandedClass = $isRecent ? 'trace-card-expanded' : 'trace-card-collapsed';
                                $isRead = isset($trace['import_trace_is_read']) && $trace['import_trace_is_read'];
                                ?>
                                <div class="trace-card <?= $expandedClass; ?> <?= $isRead ? 'trace-card-read' : 'trace-card-unread'; ?>"
                                     id="trace-card-<?= $index; ?>"
                                     data-trace-id="<?= $trace['import_trace_id']; ?>">
                                    <div class="trace-card-header" data-toggle="collapse" data-target="#trace-content-<?= $index; ?>">
                                        <!--                                        <div class="trace-card-number">#--><?php //= $index + 1; ?><!-- <i class="--><?php //= $trace['import_trace_type_icon']; ?><!-- trace_type_icon"></i> <i class="--><?php //= $trace['import_trace_status_icon']; ?><!-- trace_status_icon"></i></div>-->

                                        <div class=" sender">
                                            <!--                                            <div class="department-label">--><?php //= $this->Dictionary->GetKeyword('From'); ?><!--</div>-->
                                            <div class="department-name"><?= $trace['sender_department']; ?></div>
                                            <div class="department-user">
                                                <span><i class="fa fa-calendar"></i> <?=  ( isset($trace['import_trace_sent_date']) && !empty($trace['import_trace_sent_date'])) ? date('Y-m-d', strtotime($trace['import_trace_sent_date'])) : ''; ?></span>
                                            </div>
                                        </div>
                                        <div style="width: 50%;display: flex;justify-content: space-between;">
                                            <div style="display: flex;width: 95%;justify-content: flex-end;">
                                                <div class="trace-card-type" style="margin: 0 10px">

                                                    <span> <i class="<?= $trace['import_trace_type_icon']; ?> trace_type_icon"></i></span>
                                                    <span class="trace-type-badge"
                                                          data-toggle="tooltip"
                                                          data-title="<?= $this->Dictionary->GetKeyword('type'); ?>"
                                                          data-placement="bottom"
                                                    >
                                                    <?=  $this->Dictionary->GetKeyword($trace['import_trace_type_name'] ); ?>

                                                </span>
                                                </div>
                                                <!--                                                <div class="trace-card-status"-->
                                                <!--                                                     data-toggle="tooltip"-->
                                                <!--                                                     data-title="--><?php //= $this->Dictionary->GetKeyword('status'); ?><!--"-->
                                                <!--                                                     data-placement="bottom"-->
                                                <!--                                                >-->
                                                <!--                                                    <i class="--><?php //= $trace['import_trace_status_icon']; ?><!-- trace_status_icon"></i>-->
                                                <!--                                                    <span class="status-badge status-pending">-->
                                                <!--                                                        --><?php // echo $this->Dictionary->GetKeyword($trace['import_trace_status_name'] ?? '');
                                                //                                                            if($trace['import_trace_status_id'] == 3)
                                                //                                                            {
                                                //                                                                ?>
                                                <!--                                                                <span><i class="fa fa-calendar"></i> --><?php //=  ( isset($trace['import_trace_close_date']) && !empty($trace['import_trace_close_date'])) ? date('Y-m-d', strtotime($trace['import_trace_close_date'])) : ''; ?><!--</span>-->
                                                <!--                                                                --><?php
                                                //                                                            }
                                                //                                                        ?>
                                                <!--                                                   </span>-->
                                                <!--                                                </div>-->

                                                <?php if(isset($trace['action_type_id'])): ?>
                                                    <div class="trace-card-status"
                                                         data-toggle="tooltip"
                                                         data-title="<?= $this->Dictionary->GetKeyword('Action'); ?>"
                                                         data-placement="bottom"
                                                    >
                                                        <i class="fa fa-tasks trace_status_icon"></i>
                                                        <span class="status-badge status-pending">
                                                            <?php  echo $this->Dictionary->GetKeyword($trace['action_type_name'] ?? ''); ?>
                                                       </span>
                                                    </div>
                                                <?php endif; ?>


                                            </div>

                                            <div class="toggle-icon">
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="trace-card-body collapse <?= $isRecent ? 'in' : ''; ?>" id="trace-content-<?= $index; ?>">
                                        <div class="trace-card-route">
                                            <div class="trace-card-department sender">
                                                <div class="department-label"><?= $this->Dictionary->GetKeyword('From'); ?></div>
                                                <div class="department-name"><?= $trace['sender_department']; ?></div>
                                                <div class="department-user" style="justify-content: flex-start">
                                                    <span><i class="fa fa-user"></i> <?= $trace['sender_user']; ?></span>
                                                    <span><i class="fa fa-calendar"></i> <?= ( isset($trace['import_trace_sent_date']) && !empty($trace['import_trace_sent_date']) ) ? date('Y-m-d', strtotime($trace['import_trace_sent_date'])) : ''; ?></span>
                                                </div>
                                            </div>
                                            <div class="trace-direction-arrow">
                                                <?php if($this->UserModel->language()!="ENGLISH"){?>
                                                    <i class="fa fa-long-arrow-left"></i>
                                                <?php }else{?>
                                                    <i class="fa fa-long-arrow-right"></i>
                                                <?php }?>
                                            </div>
                                            <div class="trace-card-department receiver">
                                                <div class="department-label"><?= $this->Dictionary->GetKeyword('To'); ?></div>
                                                <div class="department-name"><?= $trace['receiver_department']; ?></div>
                                                <?php if (isset($trace['receiver_user']) && !empty($trace['receiver_user'])): ?>
                                                    <div class="department-user" style="justify-content: flex-end">
                                                        <span><i class="fa fa-user"></i> <?= $trace['receiver_user']; ?></span>
                                                        <span><i class="fa fa-calendar"></i> <?= ( isset($trace['import_trace_received_date']) && !empty($trace['import_trace_received_date']) ) ? date('Y-m-d', strtotime($trace['import_trace_received_date'])) : ''; ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if($trace['import_trace_status_id'] == 3) {?>
                                            <span class="status-badge" style="background-color: red;">
                                                  <span><i class="fa fa-calendar"></i> <?=  ( isset($trace['import_trace_close_date']) && !empty($trace['import_trace_close_date'])) ?  $this->Dictionary->GetKeyword('Closed At: ') .  date('Y-m-d H:i', strtotime($trace['import_trace_close_date'])) : ''; ?></span>
                                            </span>
                                        <?php }?>

                                        <?php if(!empty($trace['out_id'])): ?>
                                            <!--                                   <p>-->
                                            <!--                                       <a  href="--><?php //= base_url('Out/Details/' . $trace['out_id'])?><!--" target="_blank"> <i class="fa fa-book"></i> --><?php //= $this->Dictionary->GetKeyword('Out Document'); ?><!--</a>-->
                                            <!--                                   </p>-->

                                            <div class="panel panel-default book-details-panel">
                                                <div class="panel-heading" style="background-color: #f8f9fa;">
                                                    <h3 class="panel-title" style=" color: #333"><?= $this->Dictionary->GetKeyword('Out Book Brief'); ?></h3>
                                                    <a href="<?= base_url('Out/Details/' . $trace['out_id'])?>" target="_blank"> <i class="fa fa-paperclip"></i> <?= $this->Dictionary->GetKeyword('Show All Out Info'); ?></a>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="book-details-compact">
                                                        <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Code'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_book_code']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Number'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_book_number']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Date'); ?></div>
                                                            <div class="book-detail-value">
                                                                <?= $trace['out_book_issue_date'] ? date('Y-m-d', strtotime($trace['out_book_issue_date'])) : '-'; ?>
                                                            </div>
                                                        </div>

                                                        <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Subject'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_book_subject']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Category'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_book_category']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out Book Language	'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_book_language']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out From Department'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_from_department']; ?></div>
                                                        </div>

                                                        <div class="book-detail-row">
                                                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Out To Department'); ?></div>
                                                            <div class="book-detail-value"><?= $trace['out_to_department']; ?></div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                        <?php if (!empty($trace['import_trace_note'])): ?>
                                            <div class="trace-card-note">
                                                <div class="trace-note-header">
                                                    <i class="fa fa-comment-o"></i> <?= $this->Dictionary->GetKeyword('Note'); ?>
                                                </div>
                                                <div class="trace-note-content">
                                                    <?= nl2br($trace['import_trace_note']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Always show attachments section, even if empty -->
                                        <div class="trace-card-attachments">
                                            <div class="trace-attachments-header">
                                                <i class="fa fa-paperclip"></i> <?= $this->Dictionary->GetKeyword('Attachments'); ?>
                                                <?php
                                                $trace['attachments'] = $trace['import_trace_attachment'];
                                                if (!empty($trace['attachments'])): ?>
                                                    (<?= count($trace['attachments']); ?>)
                                                <?php endif; ?>
                                            </div>

                                            <?php if (!empty($trace['attachments'])): ?>
                                                <div class="trace-attachments-list">
                                                    <?php foreach ($trace['attachments'] as $attachment): ?>
                                                        <?php
                                                        $fileExtension = pathinfo($attachment['original_name'], PATHINFO_EXTENSION);
                                                        $fileIcon = 'fa-file-o';

                                                        // Determine file icon based on extension
                                                        if (in_array(strtolower($fileExtension), ['pdf'])) {
                                                            $fileIcon = 'fa-file-pdf-o';
                                                        } elseif (in_array(strtolower($fileExtension), ['doc', 'docx', 'rtf', 'txt'])) {
                                                            $fileIcon = 'fa-file-text-o';
                                                        } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx', 'csv'])) {
                                                            $fileIcon = 'fa-file-excel-o';
                                                        } elseif (in_array(strtolower($fileExtension), ['ppt', 'pptx'])) {
                                                            $fileIcon = 'fa-file-powerpoint-o';
                                                        } elseif (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])) {
                                                            $fileIcon = 'fa-file-image-o';
                                                        } elseif (in_array(strtolower($fileExtension), ['zip', 'rar', '7z', 'tar', 'gz'])) {
                                                            $fileIcon = 'fa-file-archive-o';
                                                        }
                                                        ?>
                                                        <div class="trace-attachment-item">
                                                            <a href="<?= base_url($attachment['file_path']); ?>" target="_blank" class="trace-attachment-link">
                                                                <i class="fa <?= $fileIcon; ?>"></i>
                                                                <span class="file-name"><?= $attachment['original_name']; ?></span>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="trace-attachments-empty">
                                        <span class="no-attachments-message">
                                            <i class="fa fa-info-circle"></i> <?= $this->Dictionary->GetKeyword('No Attachments'); ?>
                                        </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if (isset($import_answers) && !empty($import_answers)): ?>

            <div class="panel panel-primary mt-3 answer-panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-comments"></i> <?= $this->Dictionary->GetKeyword('Answers'); ?> (<?= count($import_answers); ?>)</h3>
                </div>
                <div class="panel-body p-0">

                    <div class="trace-flow-container">

                        <!-- Trace details cards -->
                        <div class="trace-details-container">
                            <?php
                            foreach ($import_answers as $index => $answer):
                                // Determine if this trace should be expanded by default (only the most recent ones)
                                $isRecent = ($index == 0); // Show the most recent 1 answer expanded
                                $expandedClass = $isRecent ? 'trace-card-expanded' : 'trace-card-collapsed';
                                ?>
                                <div class="trace-card trace-card-read <?= $expandedClass;?>"
                                     id="answer-card-<?= $index; ?>"
                                     data-answer-id="<?= $answer['id']; ?>">
                                    <div class="trace-card-header" data-toggle="collapse" data-target="#answer-content-<?= $index; ?>">
                                        <div class="trace-card-number">#<?= $index + 1; ?></div>
                                        <div class="trace-card-type">
                                        </div>

                                        <div class="toggle-icon">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>

                                    <div class="trace-card-body collapse <?= $isRecent ? 'in' : ''; ?>" id="answer-content-<?= $index; ?>">
                                        <div class="trace-card-route">
                                            <div class="trace-card-department sender">
                                                <div class="department-label"><?= $this->Dictionary->GetKeyword('From'); ?></div>
                                                <div class="department-name"><?= $answer['out_from_department']; ?></div>
                                            </div>

                                            <div class="trace-card-department sender">
                                                <div class="department-label"><?= $this->Dictionary->GetKeyword('Out Book Number'); ?></div>
                                                <div class="department-name"><?= $answer['out_book_number']; ?></div>
                                            </div>

                                            <div class="trace-card-department sender">
                                                <div class="department-label"><?= $this->Dictionary->GetKeyword('Out Book Date'); ?></div>
                                                <div class="department-name"><?= $answer['out_book_issue_date']; ?></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>



        <div class="text-center mt-3">
            <a href="<?= base_url('Import/Details/' . $import['import_id']); ?>" class="btn btn-info">
                <i class="fa fa-external-link"></i> <?= $this->Dictionary->GetKeyword('View Full Details'); ?>
            </a>
        </div>
    </div>
</div>



<!-- Add Trace Modal -->
<div class="modal fade" id="addTraceModal" tabindex="-1" role="dialog" aria-labelledby="addTraceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addTraceForm" action="<?= base_url('Import/AddTrace/true'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTraceModalLabel"><?= $this->Dictionary->GetKeyword('Add New Trace'); ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="import_id" value="<?= $import['import_id']; ?>">
                    <input type="hidden" name="import_trace_type_id" value="">
                    <input type="hidden" name="import_trace_status_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trace_status"><?= $this->Dictionary->GetKeyword('Action Type'); ?> *</label>
                                <select name="import_trace_action_type_id" id="trace_action_type" class="form-control" required>
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select Action Type'); ?></option>
                                    <?php if (isset($trace_action_types)): ?>
                                        <?php foreach ($trace_action_types as $action_type): ?>
                                            <option value="<?= $action_type['id']; ?>"><?= $action_type['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="trace_note"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                <textarea name="import_trace_note" id="trace_note" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="attachments"><?= $this->Dictionary->GetKeyword('Attachments'); ?></label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('You can select multiple files.'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Add Trace Modal For Sent-->
<div class="modal fade" id="addTraceModalSent" tabindex="-1" role="dialog" aria-labelledby="addTraceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addTraceFormSent" action="<?= base_url('Import/AddTrace'); ?>" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTraceModalLabel"><?= $this->Dictionary->GetKeyword('Add New Trace'); ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="import_id" value="<?= $import['import_id']; ?>">
                    <input type="hidden" name="import_trace_type_id" value="">
                    <input type="hidden" name="import_trace_status_id" value="">


                    <div class="just_for_sent_status">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="trace_status"><?= $this->Dictionary->GetKeyword('Action Type'); ?> *</label>
                                    <select name="import_trace_action_type_id" id="trace_action_type" class="form-control" required>
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select Action Type'); ?></option>
                                        <?php if (isset($trace_action_types)): ?>
                                            <?php foreach ($trace_action_types as $action_type): ?>
                                                <option value="<?= $action_type['id']; ?>"><?= $action_type['name']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="row">



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_user"><?= $this->Dictionary->GetKeyword('Receiver User'); ?></label>
                                    <select name="import_trace_receiver_user_id" id="receiver_user_id" class="form-control select2-users" required>
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>
                                        <!--                                        --><?php //if (isset($active_users)): ?>
                                        <!--                                            --><?php //foreach ($active_users as $user): ?>
                                        <!--                                                <option value="--><?php //= $user['id']; ?><!--">--><?php //= $user['name']; ?><!--</option>-->
                                        <!--                                            --><?php //endforeach; ?>
                                        <!--                                        --><?php //endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_department"><?= $this->Dictionary->GetKeyword('Receiver Department'); ?> *</label>
                                    <div class="input-group">
                                        <input type="text" name="receiver_department" id="receiver_department" class="form-control"  readonly required>
                                        <input type="hidden" name="import_trace_receiver_department_id" id="receiver_department_id">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="OpenTree('department','receiver_department','receiver_department_id','1', 'extra-section', 1)"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trace_note"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                <textarea name="import_trace_note" id="trace_note" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="attachments"><?= $this->Dictionary->GetKeyword('Attachments'); ?></label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('You can select multiple files.'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Add Trace Modal for Out -->
<div class="modal fade" id="addTraceModalOut" tabindex="-1" role="dialog" aria-labelledby="addTraceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addOutTraceForm" action="<?= base_url('Import/AjaxAddOutTrace'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTraceModalLabel"><?= $this->Dictionary->GetKeyword('Add New Trace'); ?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="import_id" value="<?= $import['import_id']; ?>">
                    <input type="hidden" name="import_trace_type_id" value="">
                    <input type="hidden" name="import_trace_status_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('To Department'); ?> *</label>
                                <div >
                                    <div class="input-group">
                                        <input type="text" id="out_to_department" class="form-control" readonly required>
                                        <input type="hidden" id="out_to_department_id" name="out_to_department_id" required>
                                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','out_to_department','out_to_department_id','1')">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" id="out_from_department" class="form-control" readonly required>
                                        <input type="hidden" id="out_from_department_id" name="out_from_department_id" required>
                                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','out_from_department','out_from_department_id','1',  'extra-section', 1)">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Category'); ?></label>
                                <div >
                                    <select name="out_book_category_id" class="form-control">
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                        <?php
                                        $categories = $this->db->get('book_category')->result();
                                        foreach($categories as $category):
                                            ?>
                                            <option value="<?= $category->book_category_id ?>"><?= $category->book_category_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Signed By'); ?></label>
                                <input type="text" name="out_signed_by" class="form-control">
                            </div>


                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Language'); ?></label>
                                <div>
                                    <select name="out_book_language_id" class="form-control">
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                        <?php
                                        $languages = $this->db->get('book_language')->result();
                                        foreach($languages as $language):
                                            ?>
                                            <option value="<?= $language->book_language_id ?>"><?= $language->book_language_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Attachments'); ?>*</label>
                                <div>
                                    <input type="file" name="attachments[]" class="form-control" multiple required>
                                    <small class="text-muted"><?= $this->Dictionary->GetKeyword('Allowed file types: pdf, doc, docx, xls, xlsx, jpg, png, gif'); ?></small>
                                </div>
                            </div>






                        </div>

                        <div class="col-md-6">
                            <!--                            <div class="form-group">-->
                            <!--                                <label class="control-label">--><?php //= $this->Dictionary->GetKeyword('Out Code'); ?><!-- *</label>-->
                            <!--                                <input type="text" name="out_book_code" class="form-control" required>-->
                            <!--                            </div>-->

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Number'); ?></label>
                                <input type="text" name="out_book_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Issue Date'); ?></label>
                                <input type="date" name="out_book_issue_date" class="form-control">
                            </div>




                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Subject'); ?> *</label>
                                <input type="text" name="out_book_subject" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Book Body'); ?></label>
                                <textarea name="out_book_body" class="form-control" rows="1"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label "><?= $this->Dictionary->GetKeyword('Electronic Copy'); ?></label>
                                <div >
                                    <select name="elec_dep_reference" class="form-control">
                                        <option value="-1"><?= $this->Dictionary->GetKeyword('Select'); ?></option>

                                        <?php  foreach($branches as $branch):?>
                                            <option value="<?= $branch['id'] ?>"
                                            ><?= $branch['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">




                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Notes'); ?></label>
                                <textarea name="out_note" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?= $this->Dictionary->GetKeyword('Copy List'); ?></label>
                                <textarea name="out_book_copy_list" class="form-control" rows="5"></textarea>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>


    $(document).ready(function(){

        $('#receiver_department_id').on('change', function() {
            const departmentId = $(this).val();
            console.log('departmentIddddddddddd', departmentId);
            if (departmentId) {
                loadUsersByDepartment(departmentId);
            }
        });

        function loadUsersByDepartment(departmentId) {
            $.ajax({
                url: '<?= base_url('User/AjaxGetUsersByDepartment') ?>',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(response) {
                    console.log('sucesss response', response);
                    const $select = $('select[name="import_trace_receiver_user_id"]');
                    $select.empty();
                    $select.append('<option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>');

                    $.each(response, function(index, user) {
                        $select.append(`<option value="${user.id}">${user.name}</option>`);
                    });

                    $select.prop('disabled', false); // 🔓 enable the select
                },
                error: function() {
                    console.log('Error loading users');
                    alert('Error loading users');
                }
            });
        }


        //  this to fix scrolling issue when modal tree department is closed
        $('#extra-modal').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open');
        });


        $('#switchCheckRead').on('change', function() {
            var isChecked = $(this).is(':checked');
            var status = isChecked ? 1 : 0;

            var url = '';
            if(status) {
                url = '<?= base_url("Import/AjaxMarkTraceAsRead"); ?>';
            } else {
                url = '<?= base_url("Import/AjaxMarkTraceAsUnread"); ?>';
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    trace_id: <?= $last_trace_id; ?>,
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        if (status) {
                            $('.read-span > strong').text('Mark As UnRead');
                        } else {
                            $('.read-span > strong').text('Mark As Read');
                        }
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating status:', error);
                    alert('An error occurred while updating the status.');
                }
            });
        });

        $('#switchCheckAssigned').on('change', function() {
            $('.switchCheckAssignedClass').hide();
            $('.assigntome-loading').css('display', 'flex'); // Show the overlay
            $.ajax({
                url: '<?= base_url("Import/AjaxAssignTraceToCurrentUser"); ?>',
                type: 'POST',
                data: {
                    trace_id: <?= $last_trace_id; ?>,
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        // hide the class switchCheckAssigned
                        //$('.switchCheckAssignedClass').hide();
                        // make this $is_assigned_to_me value 1
                        loadMessageDetails(<?= $import['import_id'] ?>);

                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function(xhr, status, error) {
                    $('.assigntome-loading').hide(); // Hide the overlay after success
                    console.error('Error updating status:', error);
                    alert('An error occurred while updating the status.');
                }
            });
        });

        $('#addTraceForm').on('submit', function(e) {
            e.preventDefault();
            $('.overlay').css('display', 'flex'); // Show the overlay
            var formData = new FormData(this);

            console.log('formData', formData);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                // success: function(response) {
                //     $('#addTraceModal').modal('hide');
                //     $('.overlay').hide(); // Hide the overlay after success
                //     location.reload();
                // },
                // error: function(xhr, status, error) {
                //     $('.overlay').hide(); // Hide the overlay after success
                //     alert('An error occurred: ' + error);
                // }
                success: function(response) {
                    // $('#addTraceModal').modal('hide');
                    // $('.overlay').hide(); // Hide the overlay after success
                    // location.reload();

                    $('.form-error').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    if(response.status !== "true") {
                        if (response.errors) {
                            for (const [field, message] of Object.entries(response.errors)) {
                                const input = $(`[name="${field}"]`);

                                input.addClass('is-invalid'); // Optional, if you're using Bootstrap

                                // Add error message right below the input
                                input.after(`<div class="form-error text-danger small">${message}</div>`);
                            }
                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }

                        $('.overlay').hide(); // Hide overlay after error
                        return;
                    }else{
                        $('.overlay').hide(); // Hide the overlay after success
                        $('#addTraceModal').modal('hide');
                        location.reload();
                    }



                },
                // error: function(xhr, status, error) {
                //     $('.overlay').hide(); // Hide the overlay after success
                //     alert('An error occurred: ' + error);
                // }

                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    try {
                        const response = JSON.parse(xhr.responseText); // Parse the server response

                        if (response.errors) {
                            // Handle validation errors
                            let errorMessages = '';
                            for (const [field, message] of Object.entries(response.errors)) {
                                errorMessages += `${field}: ${message}\n`;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle general error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (e) {
                        console.log('Error parsing JSON response:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid server response.',
                            confirmButtonText: 'OK'
                        });
                    }
                    $('.overlay').hide(); // Hide the overlay after success

                }

            });
        });


        $('#addTraceFormSent').on('submit', function(e) {
            e.preventDefault();

            $('.overlay').css('display', 'flex'); // Show the overlay

            var formData = new FormData(this);

            console.log('formData', formData);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // $('#addTraceModal').modal('hide');
                    // $('.overlay').hide(); // Hide the overlay after success
                    // location.reload();

                    $('.form-error').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    if(response.status !== "true") {
                        if (response.errors) {
                            for (const [field, message] of Object.entries(response.errors)) {
                                const input = $(`[name="${field}"]`);

                                input.addClass('is-invalid'); // Optional, if you're using Bootstrap

                                // Add error message right below the input
                                input.after(`<div class="form-error text-danger small">${message}</div>`);
                            }
                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }

                        $('.overlay').hide(); // Hide overlay after error
                        return;
                    }else{
                        $('.overlay').hide(); // Hide the overlay after success
                        $('#addTraceModal').modal('hide');
                        location.reload();
                    }



                },
                // error: function(xhr, status, error) {
                //     $('.overlay').hide(); // Hide the overlay after success
                //     alert('An error occurred: ' + error);
                // }

                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    try {
                        const response = JSON.parse(xhr.responseText); // Parse the server response

                        if (response.errors) {
                            // Handle validation errors
                            let errorMessages = '';
                            for (const [field, message] of Object.entries(response.errors)) {
                                errorMessages += `${field}: ${message}\n`;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle general error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (e) {
                        console.log('Error parsing JSON response:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid server response.',
                            confirmButtonText: 'OK'
                        });
                    }
                    $('.overlay').hide(); // Hide the overlay after success

                }


            });
        });

        $('#addOutTraceForm').on('submit', function(e) {
            e.preventDefault();
            $('.overlay').css('display', 'flex'); // Show the overlay
            var formData = new FormData(this);

            console.log('formData', formData);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    // Clear previous error messages
                    $('.form-error').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    if(response.status !== "true") {
                        if (response.errors) {
                            for (const [field, message] of Object.entries(response.errors)) {
                                const input = $(`[name="${field}"]`);

                                input.addClass('is-invalid'); // Optional, if you're using Bootstrap

                                // Add error message right below the input
                                input.after(`<div class="form-error text-danger small">${message}</div>`);
                            }
                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the document.',
                                confirmButtonText: 'OK'
                            });
                        }

                        $('.overlay').hide(); // Hide overlay after error
                        return;
                    }else{
                        $('.overlay').hide(); // Hide the overlay after success
                        $('#addTraceModal').modal('hide');
                        location.reload();
                    }





                },
                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    try {
                        const response = JSON.parse(xhr.responseText); // Parse the server response
                        console.log('Parsed error response:', response);

                        if (response.errors) {
                            // Handle validation errors
                            let errorMessages = '';
                            for (const [field, message] of Object.entries(response.errors)) {
                                errorMessages += `${field}: ${message}\n`;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle general error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the document.',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (e) {
                        console.log('Error parsing JSON response:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid server response.',
                            confirmButtonText: 'OK'
                        });
                    }
                    $('.overlay').hide(); // Hide the overlay after success

                }
            })

        });




        //document.getElementById('receiver_department').addEventListener('change', filterUsersByDepartment);

        $('.btn-self-trace').on('click', function() {

            var dataType = $(this).data('type');
            $('input[name="import_trace_type_id"]').val(dataType);

            var dataStatus = $(this).data('status');
            $('input[name="import_trace_status_id"]').val(dataStatus);

        });

        $('.btn-self-trace-sent').on('click', function() {

            var dataType = $(this).data('type');
            $('input[name="import_trace_type_id"]').val(dataType);

        });

        // Add tooltip functionality
        $('[data-toggle="tooltip"]').tooltip();

        // Make trace flow nodes clickable to jump to corresponding card and mark as read
        $('.trace-flow-node').on('click', function(){
            var traceIndex = $(this).data('trace-index');
            var targetCard = $('#trace-card-' + traceIndex);
            var targetContent = $('#trace-content-' + traceIndex);
            var traceId = $(this).data('trace-id');

            // Expand the card if it's collapsed
            if (!targetContent.hasClass('in')) {
                targetContent.collapse('show');
                targetCard.removeClass('trace-card-collapsed').addClass('trace-card-expanded');
            }

            // Scroll to the card
            $('html, body').animate({
                scrollTop: targetCard.offset().top - 100
            }, 300);

            // Highlight the card temporarily
            targetCard.addClass('highlight-card');
            setTimeout(function(){
                targetCard.removeClass('highlight-card');
            }, 1500);

            // Mark as read if unread
            if ($(this).hasClass('node-unread')) {
                AjaxMarkTraceAsRead(traceId, $(this), targetCard);
            }
        });

        // Handle card click to mark as read for unread traces
        $('.trace-card-unread').on('click', function(e) {
            if (!$(e.target).hasClass('add-attachment-btn') && !$(e.target).closest('.add-attachment-btn').length) {
                var traceId = $(this).closest('.trace-card').data('trace-id');
                var card = $(this).closest('.trace-card');
                var flowNode = $('.trace-flow-node[data-trace-id="' + traceId + '"]');

                if (card.hasClass('trace-card-unread')) {
                    AjaxMarkTraceAsRead(traceId, flowNode, card);
                }
            }
        });

        //function filterUsersByDepartment() {
        //    console.log('Filtering users by department');
        //    const departmentId = document.getElementById('receiver_department').value;
        //    const userSelect = document.getElementById('receiver_user_id');
        //    const allUsers = userSelect.querySelectorAll('option[data-department-id]');
        //
        //    // Clear existing options except the default one
        //    userSelect.innerHTML = '<option value=""><?php //= $this->Dictionary->GetKeyword("Select User"); ?>//</option>';
        //
        //    // Filter and append users belonging to the selected department
        //    allUsers.forEach(option => {
        //        if (departmentId === '' || option.getAttribute('data-department-id') === departmentId) {
        //            userSelect.appendChild(option.cloneNode(true));
        //        }
        //    });
        //}
        function loadMessageDetails(messageId) {
            $.ajax({
                url: '<?= base_url("Import/AjaxDetails/"); ?>' + messageId + '/' + <?= $selected_trace_type; ?>,
                type: 'GET',
                success: function(response) {
                    $('.assigntome-loading').hide(); // Hide the overlay after success
                    // Display the response directly in the details column
                    $('.inbox-details-column').html(response);
                },
                error: function() {
                    $('.assigntome-loading').hide(); // Hide the overlay after success
                    $('.inbox-details-column').html('<div class="alert alert-danger">Failed to load message details.</div>');
                }
            });
        }

        // Function to mark trace as read via AJAX
        function AjaxMarkTraceAsRead(traceId, flowNode, card) {
            $.ajax({
                url: '<?= base_url('Import/AjaxMarkTraceAsRead'); ?>',
                type: 'POST',
                data: {
                    trace_id: traceId,
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update UI elements
                        flowNode.removeClass('node-unread').addClass('node-read');
                        card.removeClass('trace-card-unread').addClass('trace-card-read');

                        // Update read indicators
                        flowNode.find('.trace-flow-status-indicator i').removeClass('fa-clock-o status-pending').addClass('fa-check status-completed');
                        card.find('.read-status-indicator i').removeClass('fa-envelope unread-icon').addClass('fa-check-circle read-icon');

                        // Update unread count in sidebar if exists
                        if ($('#unread-traces-count').length) {
                            var currentCount = parseInt($('#unread-traces-count').text());
                            if (currentCount > 0) {
                                $('#unread-traces-count').text(currentCount - 1);
                                if (currentCount - 1 === 0) {
                                    $('#unread-traces-count').hide();
                                }
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error marking trace as read:', error);
                }
            });
        }

        // Handle add attachment button click
        $('.add-attachment-btn').on('click', function(e){
            e.preventDefault();
            e.stopPropagation(); // Prevent triggering collapse/expand
            var traceId = $(this).data('trace-id');
            // Show modal or trigger file upload for this trace
            alert('Attachment upload feature will be implemented for trace ID: ' + traceId);
            // In a real implementation, you would open a modal dialog or redirect to an upload page
        });

        // Toggle trace card expand/collapse
        $('.trace-card-header').on('click', function() {
            var card = $(this).closest('.trace-card');
            if (card.hasClass('trace-card-collapsed')) {
                card.removeClass('trace-card-collapsed').addClass('trace-card-expanded');
            } else {
                card.removeClass('trace-card-expanded').addClass('trace-card-collapsed');
            }
        });
    });
</script>