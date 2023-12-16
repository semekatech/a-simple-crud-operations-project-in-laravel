<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        {{--<div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>--}}
        <div>
         
        </div>
        <br/>
      <div class="sidebar-brand-text mx-3">PRODUCTS MNGT SYSTEM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link " href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt" style=""></i>
            <span style="">Dashboard</span></a>
    </li>
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Products</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <?php if( app('App\Http\Controllers\Controller')->CheckPermission('Create Products') !=""){?>
                <a class="collapse-item" href="{{route('create-product')}}">Add Products</a>
                <?php } ?>
                <?php if( app('App\Http\Controllers\Controller')->CheckPermission('Manage Products') !=""){?>
                <a class="collapse-item" href="{{route('manage-products')}}">Manage Products</a>
                <?php } ?>
            </div>
        </div>
    </li>

<li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-user"
            aria-expanded="true" aria-controls="collapse-user">
            <i class="fas fa-fw fa-users"></i>
            <span>Staff Users</span>
        </a>
        <div id="collapse-user" class="collapse" aria-labelledby="heading-user" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <?php if( app('App\Http\Controllers\Controller')->CheckPermission('Assign Roles') !=""){?>
                <a class="collapse-item" href="{{ route('roles') }}">Roles</a>
                <?php } ?>
                <?php if( app('App\Http\Controllers\Controller')->CheckPermission('Add Staff') !=""){?>
                <a class="collapse-item" href="{{ route('staff-users') }}">Manage Staff</a>
                <?php } ?>
            </div>
        </div>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-user" style=""></i>
            <span style="">My Profile</span></a>
    </li>
    
  
   
</ul>

