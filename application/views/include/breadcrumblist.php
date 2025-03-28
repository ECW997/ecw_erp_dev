
<nav aria-label="breadcrumb">
<?php if(uri_string() == 'Welcome/Dashboard'){ ?>
  <ol class="breadcrumb custom-breadcrumb" style="margin-bottom: 0px;padding: 0.5rem 1rem;background-color: #0061f2;">
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> Dashbord</a></li>
  </ol>
<?php }?>

  <!-- coparate part -->
<?php if(uri_string() == 'Company'){ ?>
  <ol class="breadcrumb custom-breadcrumb" style="margin-bottom: 0px;padding: 0.5rem 1rem;background-color: #0061f2;">
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> Organization Info</a></li>
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> Company</a></li>
  </ol>
<?php }?>

<!-- user account part -->
<?php if(uri_string() == 'User/Useraccount'){ ?>
  <ol class="breadcrumb custom-breadcrumb" style="margin-bottom: 0px;padding: 0.5rem 1rem;background-color: #0061f2;">
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> User Account</a></li>
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> User Account</a></li>
  </ol>
<?php }?>
<?php if(uri_string() == 'User/Usertype'){ ?>
  <ol class="breadcrumb custom-breadcrumb" style="margin-bottom: 0px;padding: 0.5rem 1rem;background-color: #0061f2;">
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> User Account</a></li>
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> Type</a></li>
  </ol>
<?php }?>
<?php if(uri_string() == 'User/Userprivilege'){ ?>
  <ol class="breadcrumb custom-breadcrumb" style="margin-bottom: 0px;padding: 0.5rem 1rem;background-color: #0061f2;">
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> User Account</a></li>
  <li class="breadcrumb-item"><a href="" class="breadcrumb-link"> Privilege</a></li>
  </ol>
<?php }?>

</nav>
