<?php view('partials/nav.php'); ?>

<main x-data="data()" class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
    <h2 class="mb-4">اطلاعات کاربری</h2>

    <div class="row">
        <input
                type="hidden"
                value="<?= $user['id'] ?>"
                x-ref="idInput"
        >
        <div class="col">
            <label for="firstName"><b>نام</b></label>
            <input @keyup="(e) => onChange(e, 'firstName')"
                   x-model="editedUser.firstName"
                   x-ref="firstNameInput"
                   value="<?= $user['first_name'] ?>"
                   class="form-control"
                   type="text"
                   name="firstName"
                   id="firstName">
        </div>
        <div class="col">
            <label for="lastName"><b>نام خانوادگی</b></label>
            <input x-ref="lastNameInput"
                   x-model="editedUser.lastName"
                   @keyup="(e) => onChange(e, 'lastName')"
                   value="<?= $user['last_name'] ?>"
                   class="form-control"
                   type="text"
                   name="lastName" id="lastName">
        </div>
    </div>
    <div class="mt-2">
        <label for="email"><b>آدرس ایمیل</b></label>
        <input x-ref="emailInput"
               @keyup="(e) => onChange(e, 'email')"
               x-model="editedUser.email"
               value="<?= $user['email'] ?>"
               class="form-control"
               type="email"
               name="email"
               id="email">
    </div>
    <button x-ref="submitBtn" @click="onSubmit" disabled class="btn btn-success d-block w-100 mt-2">ویرایش</button>
</main>


<script>
  function data() {
    return {
      user: {
        id: '',
        firstName: '',
        lastName: '',
        email: ''
      },
      editedUser: {
        id: '',
        firstName: '',
        lastName: '',
        email: ''
      },
      init() {
        this.user = {
          id: this.$refs.idInput.value,
          firstName: this.$refs.firstNameInput.value,
          lastName: this.$refs.lastNameInput.value,
          email: this.$refs.emailInput.value,
        }
        this.editedUser = {
          id: this.$refs.idInput.value,
          firstName: this.$refs.firstNameInput.value,
          lastName: this.$refs.lastNameInput.value,
          email: this.$refs.emailInput.value,
        }
      },
      onChange(e, field) {
        this.$refs.submitBtn.disabled =
          JSON.stringify(this.user) === JSON.stringify(this.editedUser)
      },
      async onSubmit() {
        const response = await fetch('/users/update', {
          method: 'PUT',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({
            user_id: this.editedUser.id,
            first_name: this.editedUser.firstName,
            last_name: this.editedUser.lastName,
            email: this.editedUser.email
          })
        })

        if (response.ok) location.reload()
      }
    }
  }
</script>
