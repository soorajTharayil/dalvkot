<div class="row">

    <div class="col-sm-12" id="PrintMe">
        <div  class="panel panel-default thumbnail">

           


            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12" align="center">
                    <br>
                    </div>

                    <div class="col-sm-4" align="center">
                        <img alt="Picture" src="<?php echo (!empty($user->picture)?base_url($user->picture):base_url("assets/images/no-img.png")) ?>" width="150" height="150">
                        
                    </div>

                    <div class="col-sm-8">
                        <dl class="dl-horizontal">
						<?php 
							$department = $this->db->where('setting_id',2)->get('setting')->result();
							$department = $department[0];
							//print_r($department);
							?>
							<dt>Hospital Name</dt><dd><?php echo $department->title ?></dd>
							<dt>HID</dt><dd><?php echo $department->description ?></dd>
							<dt>Google Review Link</dt><dd><?php echo $department->google_review_link ?></dd>
							<dt>Online Feedback Link</dt><dd><?php echo $department->online_feedback ?></dd>
							<dt>Validity Key</dt><dd><?php echo $department->validity_key; ?></dd>
							<dt>Valid From</dt><dd><?php $decrypted_string=json_decode(openssl_decrypt($department->validity_key,"AES-128-ECB",'password'),true); echo $decrypted_string['from']; ?></dd>
							<dt>Valid To</dt><dd><?php echo $decrypted_string['to'];  ?></dd>
							<dt>QR Code</dt><dd><?php echo $department->qr_code_image ?></dd>
							<dt>Android Apk</dt><dd><?php echo $department->android_apk ?></dd>
							
						
                        </dl>
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <div class="text-center">

                  
                </div>
            </div>
        </div>
    </div>


</div>
