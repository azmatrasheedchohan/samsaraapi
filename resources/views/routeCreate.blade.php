<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MapQuest-Samsara | Dashboard</title>
</head>

<body>
    <!-- Banner -->


    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <!-- Vertical Navbar -->
        <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-dark bg-dark border-bottom border-bottom-lg-0 border-end-lg"
            id="navbarVertical">
            <div class="container-fluid">
                <!-- Toggler -->
                <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand -->
                <h2 class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                    SAMSARA & MapQuest
                </h2>
                <!-- User menu (mobile) -->
                <div class="navbar-user d-lg-none">
                    <!-- Dropdown -->
                    <div class="dropdown">
                        <!-- Toggle -->
                        <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="avatar-parent-child">
                                <img alt="Image Placeholder"
                                    src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                    class="avatar avatar- rounded-circle">
                                <span class="avatar-child avatar-badge bg-success"></span>
                            </div>
                        </a>
                        <!-- Menu -->
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Billing</a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-people"></i> Drivers
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="navbar-divider my-5 opacity-20">
                    <!-- Navigation -->

                    <!-- Push content down -->
                    <div class="mt-auto"></div>
                    <!-- User (md) -->
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Main content -->
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <!-- Card stats -->

                    <div class="card shadow border-0 mb-7">
                        <div class="card-header">
                            <h5 class="mb-0">Route Create</h5>
                        </div>



                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    



                        <div class="container my-5">
                            <div class="row justify-content-center">
                                <form action="{{ route('addresses.store') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" name="name" id="Name" class="form-control" required>
                                    </div>
                                    <!-- Address Types -->
                                    <div class="mb-3">
                                        <label for="addressTypes" class="form-label">Address Types</label>
                                        <select name="addressTypes[]" id="addressTypes" class="form-control" multiple required>
                                            <option value="yard">Yard</option>
                                            <option value="office">Office</option>
                                        </select>
                                    </div>
                                
                                    <!-- Contact IDs -->
                                    <div class="mb-3">
                                        <label for="contactIds" class="form-label">Contact IDs</label>
                                        <input type="text" name="contactIds[]" id="contactIds" class="form-control" placeholder="Enter Contact ID" required>
                                    </div>
                                
                                    <!-- External IDs -->
                                    <div class="mb-3">
                                        <label for="maintenanceId" class="form-label">Maintenance ID</label>
                                        <input type="text" name="externalIds[maintenanceId]" id="maintenanceId" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="payrollId" class="form-label">Payroll ID</label>
                                        <input type="text" name="externalIds[payrollId]" id="payrollId" class="form-control" required>
                                    </div>
                                
                                    <!-- Formatted Address -->
                                    <div class="mb-3">
                                        <label for="formattedAddress" class="form-label">Formatted Address</label>
                                        <input type="text" name="formattedAddress" id="formattedAddress" class="form-control" required>
                                    </div>
                                
                                    <!-- Latitude and Longitude -->
                                    <div class="mb-3">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control" required>
                                    </div>
                                
                                    <!-- Tag IDs -->
                                    <div class="mb-3">
                                        <label for="tagIds" class="form-label">Tag IDs</label>
                                        <input type="text" name="tagIds[]" id="tagIds" class="form-control" placeholder="Enter Tag ID" required>
                                    </div>
                                
                                    <!-- Notes -->
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea name="notes" id="notes" class="form-control"></textarea>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                                
                            </div>
                        </div>



                        <style>
                            body {
                                background: #fafbfb;
                            }


                            /* FOOTER STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
                            .page-footer {
                                position: fixed;
                                right: 0;
                                bottom: 50px;
                                display: flex;
                                align-items: center;
                                padding: 5px;
                                z-index: 1;
                            }

                            .page-footer a {
                                display: flex;
                                margin-left: 4px;
                            }
                        </style>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <style>
        /* Webpixels CSS */
        /* Utility and component-centric Design System based on Bootstrap for fast, responsive UI development */
        /* URL: https://github.com/webpixels/css */

        @import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

        /* Bootstrap Icons */
        @import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
    </style>
</body>

</html>
