<script type="text/javascript">var vars = <?php echo json_encode($data)?>;</script>
<script type="text/javascript" src="<?php echo backendAsset()?>/js/menu.js"></script>
<div class="tab-pane active fade in" id="inside">
    <!-- Striped and bordered datatable inside panel -->
    <div class="panel panel-default" id="list">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-justify"></i>List Menu</h6>
            <div class="pull-right">
                <button type="button" class="btn btn-black" id="btn-add"><i class="icon-plus"></i>Add</button>
            </div>
        </div>
        <div class="list-menu">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="0">No.</th>
                    <th width="25%">Parent Menu</th>
                    <th width="30%">Menu Name</th>
                    <th width="20%">URL</th>
                    <th width="5%">Sort</th>
                    <th width="20%">Action</th>
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /striped and bordered datatable inside panel -->

    <!-- Form add menu -->
    <div id="add-form">
        <form method="POST" id="form-add-menu" action="<?php echo site_url('menu')?>" class="validate" role="form" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Add Menu</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="add">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" id="select2">
                                <label>Parent Menu:</label>
                                 <input type="text" name="parent" class="select2-menu" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Menu Name</label>
                                <input type="text" name="name" class="required form-control" placeholder="Menu Name">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>URL:</label>
                                <input type="text" name="url" class="required form-control" placeholder="URL">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Position:</label>
                                <input type="number" name="sort" class="required form-control" placeholder="Position">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                        <input type="submit" value="Save" class="btn btn-primary" id="btn-save">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form add menu -->

    <!-- Form edit -->
    <div id="edit-form">
        <form id="form-edit-menu" action="<?php echo site_url('menu')?>" class="validate" role="form" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Edit Menu</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-edit-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="edit">
                <input type="hidden" name="id">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" id="edit-select2">
                                <label>Parent Menu:</label>
                                <input type="text" name="parent" class="select2-menu" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Menu Name</label>
                                <input type="text" name="name" class="required form-control" placeholder="Menu Name">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>URL:</label>
                                <input type="text" name="url" class="required form-control" placeholder="URL">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Position:</label>
                                <input type="number" name="sort" class="required form-control" placeholder="Position">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                        <input type="submit" value="Save" class="btn btn-primary" id="btn-save">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form edit -->

    <!-- Form view -->
    <div id="view-form">
        <form class="form-horizontal" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i class="icon-paragraph-justify2">
                </i> View Menu</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-back"><i class="icon-arrow-left"></i>Back</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Parent Menu:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="parent_menu"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Menu Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="menu_name"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">URL:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="url"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Position:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="sort"></p>
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
    <a id="notification-error" onclick="$.jGrowl('Sorry, cannot remove Menu. <br/> It\'s still have Sub Menu and Access Menu.', { theme: 'growl-error', header: 'Error!' });">Error notification</a>
</div>
<div class="for-modal">
    <!-- Delete modal -->
    <div id="delete_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?php echo site_url('menu');?>" id="form-modal-delete" name="form-modal-delete"  method="post">
                    <div class="modal-header">
                        <button id="btn-dismis" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><i class="icon-file-remove"></i>Delete Menu</h3>
                    </div>
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="menu_id" value="">
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
