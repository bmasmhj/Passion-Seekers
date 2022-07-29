<?php function displayError($err_val, $msg = "Please fill the form properly !", $time = 0)
{ ?>
   <?php $uniqueClass = "class" . uniqid() ?>
   <?php if (isset($err_val)) { ?>
      <div class="<?php echo $uniqueClass ?>" style="
         background:rgb(139, 40, 40);
         border-radius: 20px;
         color: white;
         display: block;
         font-weight: 600;
         margin-bottom:5px;
         padding:10px;
         transition: all ease 0.3s;
         ">
         <p><?php echo $msg ?></p>
         <script>
            setTimeout(() => {
               let mesg = document.querySelector('.<?php echo $uniqueClass ?>').style.opacity = 0;
            }, 3000 + <?php echo $time * 1000 ?>)
         </script>
      </div>
   <?php } ?>
<?php } ?>