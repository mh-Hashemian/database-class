function createTransaction(data) {
  $.post("/transactions", data, function () {
    location.reload()
  })
}