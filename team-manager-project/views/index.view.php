<?php require 'partials/header.php' ?>
<?php require 'partials/nav.php' ?>

<main class="container mt-3">

  <div id="addTeam" data-bs-toggle="modal" data-bs-target="#exampleModal" class="add-card text-secondary col-3 p-4 text-center" style="cursor: pointer;">
    <img class="" width="48" src="views/images/plus.svg" alt="افزودن">
    <p >افزودن تیم</p>
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
