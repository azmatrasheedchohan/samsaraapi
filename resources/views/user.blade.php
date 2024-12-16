@extends('user.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{url('user/home')}}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('user/home')}}">
                            <i class="bi bi-person"></i> Drivers
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Drivers</h1>
            </div>
           
            <div class="container-fluid">
                <!-- Card stats -->
               
                <div class="card shadow border-0 mb-7">
                    <div class="card-header">
                        
                    </div>
                    <div class="table-container">
                        <?php if (!empty($drivers['data'])): ?>
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Driver ID</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($drivers['data'] as $index => $driver): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($driver['name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($driver['id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($driver['email'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($driver['phone'] ?? 'N/A') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="alert alert-warning text-center">
                            No drivers found!
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer border-0 py-5">
                        <span class="text-muted text-sm"></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
