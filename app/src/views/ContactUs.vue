<template>
  <div>
    <form id="form" class="vue-form" @submit.prevent="submit" method="post">
      <div class="error-messages" v-show="errors.length > 0">
        <p>Error Here!</p>
        <ul>
          <li v-for="error in errors" :key="error.id">
            {{ error }}
          </li>
        </ul>
      </div>

      <h2>THIS IS EVERYTHING IN COMPONENTS</h2>
      <!-- <input-text v-model="data['first name']" placeholder="First Name">First NameComponent</input-text>
 -->


      <input-text
        v-model="data['first name']"
        type="Text"
        :required="true"
        placeholder="Paul Rudd">First Name:</input-text>


      <!-- <input-basic
          v-model="data['first name']"
        label="First Name:"
        placeholder="Paul Rudd"
        type="Text"
      />
 -->

      <hr />
      <h2>THIS IS THE DEFAULT</h2>
      <!-- <div class="form-input">
        <label for="fName">First Name<span class="red">*</span>:</label>
        <input
          id="fName"
          v-model="data['first name']"
          placeholder="Firstname"
        />
      </div> -->

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
          v-model="data['message']"
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
      <pre>
        <code>{{ data }}</code>
        <code>Endpoint:{{endpoint}}</code>
        </pre>
    </div>
  </div>
</template>

<script>
import InputText from "../components/InputText";
// import InputBasic from "../components/InputBasic";

export default {
  name: "ContactUs",
  props: {
    endpoint: String,
  },
  components: {
    InputText,
    // InputBasic
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
    submitToPHP() {

        this.axios
        .post(this.endpoint + "vue-contact-us-submit.php", this.data)
        .then(function (response) {

          console.log(response);

          if (response.data == 202) {
            alert("Email was sent.");
          } else {
            throw "Sendgrid Error: " + response.data;
          }
        })
        .catch(function (error) {
          console.error(error);
         alert("Message Failed to Send.");

        });
    },
    beforeSubmit() {

      // check if all data values that are important are filled
      if (!this.isAllRequiredFilled(this.data)) return;

      // TODO: SANTIZIE INPUTS
      console.log("being sent", this.data);


      // Submit the Data
      this.submitToPHP();
      console.log("I am submitting");
    },
    isEmailCorrect(email) {
      // yoinked from https://stackoverflow.com/a/9204568/4096078
      const re = /\S+@\S+\.\S+/;
      return re.test(email);
    },
    isAllRequiredFilled(data) {
      this.errors = [];

      // Copy the object to mutate safely
      // then get rid of non-neccessary data
      let newData = Object.assign({}, data);
      delete newData["company"];

      // check the object and add to errors
      for (const key in newData) {
        if (Array.isArray(newData[key])) break;

        if (newData[key] == null || newData[key].trim() == "") {
          const prettierWord = key[0].toUpperCase() + key.substring(1);
          this.errors.push(prettierWord + " cannot be empty");
        }
      }

      // validate email
      if (!this.isEmailCorrect(newData["email"])) {
        this.errors.push("The email does not look correct");
      }

      // check if checkbox Values exist
      if (!newData.checkboxValues.includes("acceptTerms")) {
        this.errors.push("You must accept the terms");
      }

      if (!newData.checkboxValues.includes("notRobot")) {
        this.errors.push("You must check that you are not a robot");
      }

      // If there's any errors, return false
      if (this.errors.length > 1) {
        return false;
      } else {
        return true;
      }
    },
  },
};
</script>

<style lang="scss">
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