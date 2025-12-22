<div class="content">
    <div class="row">
        <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/utils.js"></script>
        <div class="panel panel-default">

            <div class="panel-heading" style="display: none;">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("question") ?>"> <i class="fa fa-list"></i>
                        <?php echo display('patient_list') ?> </a>
                </div>
            </div>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-lg-12">

                        <?php echo form_open('question/add', 'class="form-inner"') ?>

                        <?php echo form_hidden('id', $question->id);




                        ?>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="title" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="Titile" value="<?php echo $question->title ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">English <i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="question" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="English Question" value="<?php echo $question->question ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="titlek" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="Titile Language 2" value="<?php echo $question->titlek ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Language 2<i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="questionk" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="Language 2 Question" value="<?php echo $question->questionk ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="titlem" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="Titile Language 3" value="<?php echo $question->titlem ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Language 3 <i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="questionm" type="text" class="form-control" id="name" maxlength="20"
                                    placeholder="Language 3 Question" value="<?php echo $question->questionm ?>"
                                    required>
                            </div>



                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Shortname<i
                                    class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="shortname" type="text" class="form-control" maxlength="15" id="patient_id"
                                    placeholder="Patients ID" value="<?php echo $question->shortname ?>" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="ui buttons">
                                    <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                    <div class="or"></div>
                                    <button class="ui positive button"
                                        type="submit"><?php echo display('save') ?></button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>