<div class="content">
	<div class="row">
		<!--  table area -->
		<div class="col-sm-12">
			<div class="panel panel-default thumbnail">

				<div class="panel-body">
				<table class=" table table-striped table-bordered  no-footer dtr-inline " >
                             <tr>
						<td class="title">IP DEPARTMENTS SETUP</td>
                        <td class="butt"><a href="<?php echo base_url("SetupEfeeder/departmetnip") ?>" class="btn btn-primary" >ADD</a> </td>
                 
                </tr>
                <tr>
						<td class="title">OP DEPARTMENT SETUP</td>
                        <td class="butt"><a href="<?php echo base_url("SetupEfeeder/departmetnop") ?>" class="btn btn-primary">ADD</a> </td>
                </tr>
                <tr>
						<td class="title">INT DEPARTMENT </td>
                        <td class="butt"><a href="<?php echo base_url("SetupEfeeder/departmentinterim") ?>" class="btn btn-primary">ADD</a> </td>
                </tr>
                <tr>
						<td  class="title">IP JSON</td>
                        <td class="butt"><a href="<?php echo base_url("SetupEfeeder/questionjson") ?>" class="btn btn-primary"  target="_blank">ADD</a> </td>
                </tr>
                <tr>
						<td class="title">OP JSON</td>
                        <td class="butt"><a href="<?php echo base_url("SetupEfeeder/questionjsonop") ?>" class="btn btn-primary"  target="_blank">ADD</a></td>
                </tr>
                </table>
			
				</div>
			</div>
		</div>
	</div>
</div>
<style>
    .butt.title{
       font-weight: bold;
    }
.butt{
        text-align: center;
        align-items: center;
    }
</style>