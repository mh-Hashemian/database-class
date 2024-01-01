function createTransaction(data) {
  $.post("/transactions", data, function () {
    location.reload()
  })
}

chartOptions = {
  plugins: {
    title: {
      display: true,
      text: 'گزارش ماهانه',
      font: {
        size: 18,
        weight: 'bold'
      }
    },
    legend: {
      display: false,
    }
  }
}

