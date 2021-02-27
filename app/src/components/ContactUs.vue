<template>
  <div>
    <form class="vue-form" @submit.prevent="submit">
      <div class="error-messages"></div>

      <div class="form-input">
        <label for="fName">First Name</label>
        <input v-model="fName" id="fName" />
      </div>

      <div class="form-input">
        <label for="lName">Last Name</label>
        <input type="text" id="lName" name="lName" />
      </div>

      <div class="form-input">
        <label for="userEmail">Email</label>
        <input id="userEmail" type="email" name="userEmail" />
      </div>

      <div class="form-input">
        <label for="userCompany">Company</label>
        <input type="text" id="userCompany" name="userCompany" />
      </div>

      <div class="form-radio-group">
        <p>Department</p>

        <div>
          <div class="form-radio">
            <input
              type="radio"
              id="departmentCS"
              name="department"
              value="departmentCS"
            />
            <label for="departmentCS">Customer Service</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentIT"
              name="department"
              value="departmentIT"
            />
            <label for="departmentIT">IT Issue</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentBill"
              name="department"
              value="departmentBill"
            />
            <label for="departmentBill">Billing</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentOther"
              name="department"
              value="departmentOther"
            />
            <label for="departmentOther">Other</label>
          </div>
        </div>

      </div>
      <div class="form-input">
        <label for="subjectLine">Email Subject Line</label>
        <input type="text" id="subjectLine" name="subjectLine" />
      </div>

      <div class="form-textarea">
        <label for="userMessage">Message</label>
        <textarea id="userMessage" name="userMessage"></textarea>
      </div>

      <button type="submit">Submit</button>
    </form>

    <div class="debug">
      <pre><code>{{ data }}
          {{ fName }} </code></pre>
    </div>
  </div>
</template>

<script>
export default {
  name: "ContactUs",
  props: {
    params: Object,
  },
  data: function () {
    return {
      data: "poop",
      fName: ""
    };
  },
};
</script>

<style lang="scss" scoped>
label,
p {
  font-size: 1.5rem;
  margin: 0;
  font-weight: bold;
  text-align: left;
}

.form-input, .form-textarea {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  margin-bottom: 1rem;

  label {
    flex: 1 1 20%;
  }

  input, textarea {
    flex: 1 1 80%;
    background: #fff;
    border-radius: 0;
    border-style: solid;
    border-width: 0.1rem;
    box-shadow: none;
    display: block;
    font-size: 1.6rem;
    letter-spacing: -0.015em;
    margin: 0;
    max-width: 100%;
    padding: 1.5rem 1.8rem;
    width: 100%;
  }

  
}

.form-radio-group {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 1rem;


  p {
    flex: 1 1 20%;
  }

  div {
    flex: 1 1 80%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  input {
    margin: 0 4px 0 0;
  }
}

button {
    margin-top: 3rem;
}
</style>