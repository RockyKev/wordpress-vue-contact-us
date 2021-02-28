<template>
  <div>
    <form class="vue-form" @submit.prevent="submit">
      <div class="error-messages" v-show="errors.length > 0">
        <p>Error Here!</p>
        <ul>
          <li v-for="error in errors" :key="error.id">
            {{ error }}
          </li>
        </ul>
      </div>

      <div class="form-input">
        <label for="fName">First Name<span class="red">*</span>:</label>
        <input
          id="fName"
          v-model="data['first name']"
          placeholder="Firstname"
        />
      </div>

      <div class="form-input">
        <label for="lName">Last Name<span class="red">*</span>:</label>
        <input id="lName" v-model="data['last name']" placeholder="Lastname" />
      </div>

      <div class="form-input">
        <label for="userEmail">Email<span class="red">*</span>:</label>
        <input
          id="userEmail"
          v-model="data['email']"
          placeholder="theemail@website.com"
        />
      </div>

      <div class="form-input">
        <label for="userCompany">Company:</label>
        <input
          id="userCompany"
          v-model="data['company']"
          placeholder="Macrosoft"
        />
      </div>

      <div class="form-radio-group">
        <p>Department<span class="red">*</span>:</p>

        <div>
          <div class="form-radio">
            <input
              type="radio"
              id="departmentCS"
              v-model="data['department']"
              value="departmentCS"
            />
            <label for="departmentCS">Customer Service</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentIT"
              v-model="data['department']"
              value="departmentIT"
            />
            <label for="departmentIT">IT Issue</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentBill"
              v-model="data['department']"
              value="departmentBill"
            />
            <label for="departmentBill">Billing</label>
          </div>

          <div class="form-radio">
            <input
              type="radio"
              id="departmentOther"
              v-model="data['department']"
              value="departmentOther"
            />
            <label for="departmentOther">Other</label>
          </div>
        </div>
      </div>
      <div class="form-input">
        <label for="subjectLine"
          >Email Subject Line<span class="red">*</span>:</label
        >
        <input
          id="subjectLine"
          v-model="data['subject line']"
          placeholder="Reaching out for help"
        />
      </div>

      <div class="form-textarea">
        <label for="userMessage">Message<span class="red">*</span>:</label>
        <textarea
          id="userMessage"
          v-model="data['message ']"
          placeholder="Enter your query here"
        ></textarea>
      </div>

      <div class="form-checkbox-group">
        <div class="form-checkbox">
          <input
            type="checkbox"
            id="checkboxSubscribe"
            value="subscribe"
            v-model="data.checkboxValues"
          />
          <label for="checkboxSubscribe"
            >I want to subscribe to the email list</label
          >
        </div>

        <div class="form-checkbox">
          <input
            type="checkbox"
            id="checkboxTerms"
            value="acceptTerms"
            v-model="data.checkboxValues"
          />
          <label for="checkboxTerms"
            >I accept Terms & Conditions<span class="red">*</span></label
          >
        </div>

        <div class="form-checkbox">
          <input
            type="checkbox"
            id="checkboxNotRobot"
            value="notRobot"
            v-model="data.checkboxValues"
          />
          <label for="checkboxNotRobot"
            >I am not a robot<span class="red">*</span></label
          >
        </div>
      </div>

      <button type="submit" @click="beforeSubmit()">Submit</button>
    </form>

    <div class="debug">
      <h2>This data gets sent to PHP</h2>
      <pre><code>{{ data }}
          </code></pre>
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
      data: {
        "first name": null,
        "last name": null,
        email: null,
        company: null,
        department: null,
        "subject line": null,
        message: null,
        checkboxValues: [],
      },
      errors: [],
    };
  },
  methods: {
    beforeSubmit() {
      console.log("I'm here!");

      // check if all data values that are important are filled;
      // exit if not
      if (!this.isAllRequiredFilled(this.data)) return;
    },
    isEmailCorrect(email) {
      // yoinked from https://stackoverflow.com/a/9204568/4096078

      const re = /\S+@\S+\.\S+/;
      return re.test(email);
    },
    isAllRequiredFilled(data) {
      console.log("NOT HAPPY!");

      this.errors = [];

      // Copy the object to mutate safely
      // then get rid of non-neccessary data
      let newData = Object.assign({}, data);
      delete newData["company"];

      // check the object and add to errors
      for (const key in newData) {
        if (Array.isArray(newData[key])) break;
        console.log({ key });

        if (newData[key] == null || newData[key].trim() == "") {
          const prettierWord = key[0].toUpperCase() + key.substring(1);
          this.errors.push(prettierWord + " cannot be empty");
        }
      }

      // validate email
      if (!this.isEmailCorrect(newData["userEmail"])) {
        this.errors.push("The email does not look correct");
      }

      // check if checkbox Values exist
      if (!newData.checkboxValues.includes("notRobot")) {
        this.errors.push("You must check that you are not a robot");
      }

      if (!newData.checkboxValues.includes("acceptTerms")) {
        this.errors.push("You must accept the turns");
      }

      // else fill errors and return false
      if (this.errors.length > 1) return false;
    },
  },
};
</script>

<style lang="scss" scoped>
button {
  margin-top: 3rem;
}

label,
p {
  font-size: 1.5rem;
  margin: 0;
  font-weight: bold;
  text-align: left;
}

.form-input,
.form-textarea {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  margin-bottom: 1rem;

  label {
    flex: 1 1 20%;
  }

  input,
  textarea {
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

  label {
    font-weight: 400;
  }
}

.form-checkbox-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding-left: 20%;
}

.red {
  color: red;
}

.error-messages {
  color: red;
  ul {
    margin: 0;

    li {
      margin: 0;
      font-size: 1rem;
      list-style: none;
      text-align: left;
    }
  }
}
</style>