<?php view("partials/nav.php") ?>

<main class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
    <table class="table table-bordered">
        <thead>
        <tr class="text-center">
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-center align-middle">
            <td>
                <input
                        class="name form-control text-center"
                        id="playerFirstname"
                        name="playerFirstname"
                        type="text"
                        value="<?= $player['first_name'] ?>"
                />
            </td>
            <td>
                <input
                        class="name form-control text-center"
                        id="playerLastname"
                        name="playerLastname"
                        type="text"
                        value="<?= $player['last_name'] ?>"
                />
            </td>
            <td class="">
                <div class="d-flex flex-lg-row flex-column gap-1">
                    <button id="editBtn" disabled type="submit" class="btn btn-success btn-sm w-100">ویرایش</button>
                    <form class="d-inline-block mb-0 w-100"
                          action="/players/delete?teamId=<?= $player['team_id'] ?>&playerId=<?= $player['id'] ?>"
                          method="POST">
                        <button class="btn btn-danger btn-sm w-100">حذف</button>
                    </form>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <hr>

    <h4 class="mb-3">بدهی های پیشین</h4>
    <?php if (count($player_debts) === 0): ?>
        <p>بازیکن هیچ بدهی ندارد.</p>
    <?php endif; ?>
    <?php if(count($player_debts) > 0): ?>
    <table class="table table-bordered align-middle text-center">
        <thead>
        <tr>
            <th>عنوان جلسه</th>
            <th>تاریخ برگزاری</th>
            <th>مبلغ بدهی</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody id="paymentModalDebts">
            <?php foreach($player_debts as $debt): ?>
                <tr>
                    <td><?= $debt['title'] ?></td>
                    <td><?= formatDate($debt['date']) ?></td>
                    <td><?= convertToPersianNumber($debt['amount_owed']) ?> <b>تومان</b></td>
                    <td>
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#payDebtModal"
                            onclick="openPayDebtModal(<?= $debt['session_id'] ?>, <?= $debt['entrance_fee'] ?>,<?= $debt['amount_owed'] ?>)"
                                class="btn btn-outline-success"
                        >پرداخت بدهی
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif ?>

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
  payDebtInput = $("#pay-debt-amount")

  let sessionId, entranceFee, debtAmount
  function openPayDebtModal(sessionID, entranceAmount, amount) {
    sessionId = sessionID
    entranceFee = entranceAmount
    debtAmount = amount
    payDebtInput.attr('value', debtAmount)
    payDebtInput.attr('max', debtAmount)
  }

  function closePayment() {
    $("#payment-amount").val(1000)
  }

  const playerId = +"<?= $player_id?>"
  function payDebt() {
    const prevPayment = entranceFee - debtAmount

    const amount = +payDebtInput.val()
    const amountPaid = prevPayment + amount
    const amountOwed = entranceFee - amountPaid

    createTransaction({
      player_id: playerId,
      session_id: sessionId,
      amount_paid: amountPaid,
      amount_owed: amountOwed,
    })
  }

  const firstnameValue = $("#playerFirstname").val();
  const lastnameValue = $("#playerLastname").val();

  $(".name").keyup(function (e) {
    const {value, id: targetId} = e.target;
    const currentValue = value.trim();

    if (targetId === 'playerFirstname') {
      if (firstnameValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }

    } else if (targetId === 'playerLastname') {
      if (lastnameValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    }
  })

  $("#editBtn").click(function () {
    $.post("/players/update", {
      playerId: <?= $player_id ?>,
      firstname: $("#playerFirstname").val(),
      lastname: $("#playerLastname").val(),
    }, function (data, status) {
      location.reload();
    })
  })
</script>