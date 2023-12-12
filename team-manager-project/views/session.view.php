<?php view('partials/header.php') ?>
<?php view('partials/nav.php') ?>

<main class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
    <form class="mt-4 border py-3 px-4" action="/sessions/create?teamId=<?= $team['id'] ?>" method="POST">
        <div class="row">
            <div class="col-sm-4 mb-sm-0 mb-2">
                <label class="mb-1" for="title">عنوان جلسه</label>
                <input
                        value="<?= $session['title'] ?>"
                        class="form-control"
                        type="text"
                        name="title"
                        id="title"
                  <?= $is_session_ended ? 'disabled' : '' ?>
                        required
                >
            </div>
            <div class="col-sm-4 mb-sm-0 mb-2">
                <label class="mb-1" for="date">تاریخ جلسه</label>
                <input
                        value="<?= $session['date'] ?>"
                        class="form-control"
                        type="date"
                        name="date"
                        id="date"
                        value="<?= date("Y-m-d"); ?>"
                        min="<?= date("Y-m-d"); ?>"
                  <?= $is_session_ended ? 'disabled' : '' ?>
                        required
                >
            </div>
            <div class="col-sm-4 mb-sm-0 mb-2">
                <label class="mb-1" for="fee">هزینه ورودی</label>
                <div class="d-flex align-items-center gap-2">
                    <input
                            value="<?= $session['entrance_fee'] ?>"
                            class="form-control"
                            type="number"
                            name="fee"
                            id="fee"
                            min="0"
                            step="1000"
                      <?= $is_session_ended ? 'disabled' : '' ?>
                            required
                    >
                    <b>تومان</b>
                </div>
            </div>
        </div>
      <?php if (!$is_session_ended): ?>
          <button id="editBtn" disabled class="btn btn-success w-100 mt-3">ویرایش</button>
      <?php endif; ?>
    </form>

    <hr class="my-3"/>

  <?php if (!$is_session_ended): ?>
      <div class="d-flex align-items-center justify-content-between mb-3">
          <h3 class="mb-0">لیست بازیکنان حاضر</h3>

          <div class="">
              <button
                      class="btn btn-primary btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#playersListModal"
              >ثبت حضور بازیکن
              </button>

              <button
                      class="btn btn-dark btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#endSessionModal"
              >
                  اتمام جلسه
              </button>
          </div>
      </div>
  <?php endif; ?>


  <?php if (!$is_session_ended && count($present_players) === 0): ?>
      <h5>هیچ بازیکنی حاضر نیست!</h5>
  <?php endif; ?>
  <?php if (count($present_players) > 0): ?>
      <table class="table table-bordered">
          <thead>
          <tr class="text-center">
              <th>شناسه</th>
              <th>نام</th>
              <th>نام خانوادگی</th>
              <th>عملیات</th>
          </tr>
          </thead>
          <tbody id="presentPlayers">
          <?php foreach ($present_players as $present_player): ?>
              <tr class="text-center align-middle">
                  <td><b><?= $present_player['id'] ?></b></td>
                  <td><?= $present_player['first_name'] ?></td>
                  <td><?= $present_player['last_name'] ?></td>
                  <td class="align-middle">
                      <div class="d-flex flex-lg-row flex-column gap-1 align-middle h-100">
                        <?php if ($is_session_ended): ?>
                            <button
                                    onclick="playerId = <?= $present_player['id'] ?>"
                                    data-player-id="<?= $present_player['id'] ?>"
                                    class="btn btn-success btn-sm w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paymentModal"
                            >پرداخت
                            </button>
                        <?php endif; ?>

                        <?php if ($is_session_ended): ?>
                            <button
                                    onclick="addDebt(<?= $present_player['id'] ?>)"
                                    class="btn btn-outline-danger btn-sm w-100"
                            >ثبت بدهی
                            </button>
                        <?php endif; ?>

                        <?php if (!$is_session_ended): ?>
                            <button
                                    onclick="removeAttendance(<?= $present_player['id'] ?>)"
                                    type="submit"
                                    class="btn btn-danger btn-sm w-100"
                            >حذف
                            </button>
                        <?php endif; ?>
                      </div>
                  </td>
              </tr>
          <?php endforeach; ?>
          </tbody>
      </table>
  <?php endif; ?>

  <?php if ($is_session_ended && count($present_players) === 0): ?>
      <p>این سالن در تاریخ
          <b><?= $formatter->format(date_create($session['date'])) ?></b>
          برگزار شد.
      </p>
        <p class="alert alert-info h4">
            مبلغ <b><?= convertToPersianNumber($collected_amount) ?> تومان</b> جمع آوری شد.
        </p>
  <?php endif; ?>


  <?php if ($is_session_ended): ?>
      <hr class="my-3"/>

      <h3>لیست بدهکاران</h3>
    <?php if (count($debtors) === 0): ?>
          <h5>هیچ بازیکنی بدهکار نیست!</h5>
    <?php endif; ?>
    <?php if (count($debtors) > 0): ?>
          <table class="table table-bordered align-middle text-center">
              <thead>
              <tr>
                  <th>نام بازیکن</th>
                  <th>مبلغ بدهی</th>
                  <th>عملیات</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($debtors as $debtor): ?>
                  <tr>
                      <td><?= $debtor['name'] ?></td>
                      <td><?= convertToPersianNumber($debtor['amount_owed']) ?></td>
                      <td>
                          <button
                              data-bs-toggle="modal"
                              data-bs-target="#payDebtModal"
                              onclick="openPayDebtModal(<?= $debtor['id'] ?>, <?= $debtor['amount_owed'] ?>)"
                              class="btn btn-outline-success"
                          >پرداخت بدهی</button>
                      </td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
    <?php endif; ?>
  <?php endif; ?>


    <div class="modal fade" id="playersListModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">لیست حضور غیاب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?php if (count($absence_players) === 0): ?>
                      همه بازیکنان حاضر هستند.
                  <?php endif; ?>
                  <?php if (count($absence_players) > 0): ?>
                      <table class="table table-bordered">
                          <thead>
                          <tr class="text-center">
                              <th>شناسه</th>
                              <th>نام</th>
                              <th>نام خانوادگی</th>
                              <th>عملیات</th>
                          </tr>
                          </thead>
                          <tbody id="absencePlayers">
                          <?php foreach ($absence_players as $absence_player): ?>
                              <tr data-player-id="<?= $absence_player['id'] ?>"
                                  class="absence-player text-center align-middle">
                                  <td><b><?= $absence_player['id'] ?></b></td>
                                  <td><?= $absence_player['first_name'] ?></td>
                                  <td><?= $absence_player['last_name'] ?></td>
                                  <td class="operation-td align-middle">

                                      <img
                                              class="attend-img"
                                              onclick="attendPlayer(event, <?= $absence_player['id'] ?>)"
                                              width=28
                                              style="cursor:pointer;"
                                              src="images/check.svg"
                                              alt="حاضر"
                                      >

                                      <img
                                              class="remove-img"
                                              onclick="removePlayer(event, <?= $absence_player['id'] ?>)"
                                              width=28
                                              style="cursor:pointer;"
                                              src="images/x-mark.svg"
                                              alt="حاضر"
                                      >
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                          </tbody>
                      </table>
                  <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button id="closeModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن
                    </button>
                    <button id="savePresentPlayers" type="button" class="btn btn-primary">ثبت حضور</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="endSessionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اتمام جلسه</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    اطلاعات بعد از اتمام و بستن جلسه <b>قابل ویرایش نیستند!</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    <button id="endSession" type="button" class="btn btn-primary">اتمام</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">پرداخت ورودی</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">مبلغ پرداختی</label>
                    <input id="payment-amount" value="<?= $session['entrance_fee'] ?>" type="number" min="1000"
                           max="<?= $session['entrance_fee'] ?>" step="1000" class="form-control">
                </div>
                <div class="modal-footer">
                    <button onclick="closePayment()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        بستن
                    </button>
                    <button onclick="pay()" type="button" class="btn btn-success">پرداخت</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payDebtModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">پرداخت بدهی</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">مبلغ پرداختی</label>
                    <input
                        id="pay-debt-amount"
                        type="number"
                        min="1000"
                        step="1000"
                        class="form-control"
                    >
                </div>
                <div class="modal-footer">
                    <button onclick="closePayment()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        بستن
                    </button>
                    <button onclick="payDebt()" type="button" class="btn btn-success">پرداخت</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
  $(".remove-img").hide()
  let presentPlayersIDs = []

  function attendPlayer(event, playerId) {
    // push id into array that we want to POST
    presentPlayersIDs.push(playerId);

    // update UI based
    const element = $(`.absence-player[data-player-id=${playerId}]`)
    element.addClass("table-active")

    element.children(".operation-td").children(".attend-img").hide()
    element.children(".operation-td").children(".remove-img").show()
  }

  function removePlayer(event, playerId) {
    const index = presentPlayersIDs.indexOf(playerId)
    presentPlayersIDs.splice(index, 1)

    const element = $(`.absence-player[data-player-id=${playerId}]`)
    element.removeClass("table-active")

    element.children(".operation-td").children(".remove-img").hide()
    element.children(".operation-td").children(".attend-img").show()
  }

  $("#closeModal").on("click", function () {
    presentPlayersIDs = []
    $(".absence-player").removeClass("table-active")
    $(".attend-img").show()
    $(".remove-img").hide()
  })

  $("#savePresentPlayers").on("click", function () {
    $.post('/attendance', {
      player_ids: presentPlayersIDs,
      session_id: <?= $session['id'] ?>
    }, function () {
      location.reload();
    })
  })

  function closePayment() {
    $("#payment-amount").val("<?= $session['entrance_fee'] ?>")
  }

  function createTransaction(data) {
    $.post("/transactions", data, function () {
      location.reload()
    })
  }

  const entranceFee = +"<?= $session['entrance_fee'] ?>"
  let playerId

  function pay() {
    const amountPaid = +$("#payment-amount").val();
    const amountOwed = entranceFee - amountPaid

    createTransaction({
      player_id: playerId,
      session_id: <?= $session['id'] ?>,
      amount_paid: amountPaid,
      amount_owed: amountOwed,
    })
  }

  let debtAmount
  payDebtInput = $("#pay-debt-amount")
  function openPayDebtModal(debtorId, amount) {
    playerId = debtorId
    debtAmount = amount
    payDebtInput.attr('value', debtAmount)
    payDebtInput.attr('max', debtAmount)
  }

  function payDebt() {
    const prevPayment = entranceFee - debtAmount

    const amount = +payDebtInput.val()
    const amountPaid = prevPayment + amount
    const amountOwed = entranceFee - amountPaid

    createTransaction({
      player_id: playerId,
      session_id: <?= $session['id'] ?>,
      amount_paid: amountPaid,
      amount_owed: amountOwed,
    })
  }

  function addDebt(playerId) {
    const amountPaid = 0;

    createTransaction({
      player_id: playerId,
      session_id: <?= $session['id'] ?>,
      amount_paid: amountPaid,
      amount_owed: <?= $session['entrance_fee'] ?>,
    })
  }

  function removeAttendance(playerId) {
    $.ajax({
      url: "/attendance",
      type: "DELETE",
      contentType: "application/json",
      data: JSON.stringify({
        player_id: playerId,
        session_id: <?= $session_id ?>
      }),
      success: function () {
        location.reload()
      }
    })
  }

  function endSession() {
    const title = $("#title").val();
    const date = $("#date").val();
    const fee = $("#fee").val();

    $.ajax({
      url: '/sessions/update',
      type: 'PUT',
      data: JSON.stringify({
        session_id: "<?= $session_id ?>",
        title: title,
        date: date,
        entrance_fee: fee,
        ended_at: Date.now(),
      }),
      success: function () {
        location.reload()
      }
    })
  }

  $("#endSession").on("click", endSession)


  const titleInput = $("#title")
  const titleValue = titleInput.val();
  const dateValue = $("#date").val();
  const feeValue = $("#fee").val();

  titleInput.on("keyup", function (e) {
    const currentValue = e.target.value;

    if (titleValue !== currentValue && currentValue !== "") {
      $("#editBtn").removeAttr('disabled')
    } else {
      $("#editBtn").attr('disabled', true)
    }
  })

  $(".form-control").change(function (e) {
    const {value, id: targetId} = e.target;
    const currentValue = value.trim();

    if (targetId === 'date') {
      if (dateValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    } else if (targetId === 'fee') {
      if (feeValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    }
  })

  $("#editBtn").click(function () {
    const title = $("#title").val();
    const date = $("#date").val();
    const fee = $("#fee").val();

    $.ajax({
      url: '/sessions/update',
      type: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify({
        session_id: "<?= $session_id ?>",
        title: title,
        date: date,
        entrance_fee: fee,
      }),
      success: function (response) {
        location.reload()
      }
    })
  })

</script>