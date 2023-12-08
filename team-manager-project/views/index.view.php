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
        
        <img class="" width="48" src="images/plus.svg" alt="افزودن">
        <p >افزودن تیم</p>
      </div>
    </div>
  
    <!-- display teams -->
    <?php foreach($teams as $team): ?>
      <div class="p-1">
        <div class="card px-0">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 h6">
              تعداد بازیکنان: <?= $team['players_count'] ?>
            </h5>

            <img 
              style="cursor: pointer;" 
              class="delete-team"
              data-team-name="<?= $team['name'] ?>"
              data-team-id="<?= $team['id'] ?>"
              data-bs-toggle="modal" 
              data-bs-target="#staticBackdrop"
              width="24" 
              src="images/delete.svg"
              alt="حذف تیم"
            >
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= $team['name'] ?></h5>
            <a href="/teams?id=<?= $team['id'] ?>" class="btn btn-primary mt-3 w-100">جزئیات</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">هشدار</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="deleteContent" class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
          <button 
            id="deleteTeam"
            type="button" 
            class="btn btn-danger"
          >حذف</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/teams/create" method="POST">
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

<script>
  let teamId;
  $(".delete-team").click(function(e) {
    const teamName = e.currentTarget.attributes['data-team-name'].value
    teamId = e.currentTarget.attributes['data-team-id'].value

    $("#deleteContent").html(`
      <p class="h6 mb-0">آیا از حذف تیم <b>"${teamName}"</b> اطمینان دارید؟</p>
    `)

  })

  $("#deleteTeam").click(function() {
    if (!teamId) return;

    $.ajax({
      url: `/teams/delete?teamId=${teamId}`,
      type: 'DELETE',
      success: function(result) {
        console.log(result)
        //location.reload();
      }
    })
  })
</script>
