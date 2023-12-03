<?php require 'partials/header.php' ?>
<?php require 'partials/nav.php' ?>

<main class="container mt-3">

  <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
    <div class="p-1">
      <div 
        id="addTeam" 
        data-bs-toggle="modal" 
        data-bs-target="#exampleModal" 
        class="add-card h-100 text-secondary p-4 text-center d-flex flex-column justify-content-center align-items-center" 
        style="cursor: pointer;"
      >
        
        <img class="" width="48" src="views/images/plus.svg" alt="افزودن">
        <p >افزودن تیم</p>
      </div>
    </div>
  
    <!-- display teams -->
    <?php foreach($teams as $team): ?>
      <div class="p-1">
        <div class="card px-0">
          <h5 class="card-header h6">تعداد بازیکنان: <?= $team['players_count'] ?></h5>
          <div class="card-body">
            <h5 class="card-title"><?= $team['name'] ?></h5>
            <a href="/team?id=<?= $team['id'] ?>" class="btn btn-primary mt-3 w-100">جزئیات</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/create-team" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">افزودن تیم</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label class="font-weight-bold text-2">نام تیم</label>
            <input class="form-control" name="teamName" type="text" required />
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">افزودن</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</main>
