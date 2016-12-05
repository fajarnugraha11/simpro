<script type="text/javascript">var vars = <?php echo json_encode($data)?>;</script>
<script type="text/javascript" src="<?php echo backendAsset()?>/js/member_order.js"></script>
<div class="tab-pane active fade in" id="inside">
    <div class="panel panel-default" id="list">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-justify"></i>List Member Order</h6>

        </div>
        <div class="list-member">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="0">No.</th>
                    <th width="20%">Name</th>
                    <th width="10%">DOB</th>
                    <th width="20%">Address</th>
                    <th width="20%">email</th>
                    <th width="20%">Phone</th>
                    <th width="20%">Number Order</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Form view -->
    <div id="view-form">
        <form class="form-horizontal" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i class="icon-paragraph-justify2">
                        </i> View Member Order</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-back"><i class="icon-arrow-left"></i>Back</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="name"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">dob:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="birthday"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Address:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="address"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Email:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="email"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Phone:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="phone"></p>
                        </div>
                    </div>  
					<div class="form-group">
                        <label class="col-sm-2 control-label text-right">Number Order:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="numberorder"></p>
                        </div>
                    </div>  
                </div>
            </div>
        </form>
    </div>
    <!-- /form view -->
</div>

<div class="hide">
    <a id="notification-succes" onclick="$.jGrowl('Everything is fine', { theme: 'growl-success', header: 'Success!' });">Success notification</a>
    <a id="notification-error" onclick="$.jGrowl('Sorry, cannot remove. <br/> It\'s still have relation with another table.', { theme: 'growl-error', header: 'Error!' });">Error notification</a>
</div>

<div class="for-modal">
    <!-- Delete modal -->
    <div id="delete_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?php echo site_url('member');?>" id="form-modal-delete" name="form-modal-delete"  method="post">
                    <div class="modal-header">
                        <button id="btn-dismis" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><i class="icon-file-remove"></i>Delete</h3>
                    </div>
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="">
                    <div class="modal-body with-padding">
                        <p>Are you sure want to delete <i id="label-name"></i> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" data-dismiss="modal">No</button>
                        <button type="submit" id="btn-modal-delete" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /delete modal -->
</div>
