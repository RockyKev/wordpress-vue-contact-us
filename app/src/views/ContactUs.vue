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

      <input-text
        v-model="userData['first name']"
        type="Text"
        :required="true"
        placeholder="Paul"
        >First Name:</input-text
      >

      <input-text
        v-model="userData['last name']"
        type="Text"
        :required="true"
        placeholder="Rudd"
        >Last Name:</input-text
      >

      <input-text
        v-model="userData['email']"
        type="Email"
        :required="true"
        placeholder="theemail@website.com"
        >Email:</input-text
      >

      <input-text
        v-model="userData['company']"
        type="Text"
        :required="true"
        placeholder="Macrosoft"
        >Company:</input-text
      >

      <!-- TODO: All IDs are shared. They need to be refreshed -->
      <div class="form-radio-group">
        <p>Department<span class="red">*</span>:</p>
        <input-radio
          v-model="userData['department']"
          value="departmentCS"
          required
          >Customer Service</input-radio
        >

        <input-radio v-model="userData['department']" value="departmentIT"
          >IT Issue</input-radio
        >

        <input-radio v-model="userData['department']" value="departmentBill"
          >Billing</input-radio
        >
      </div>

      <input-text
        v-model="userData['subject line']"
        type="Text"
        :required="true"
        placeholder="Reaching out for help"
        >Email Subject Line:</input-text
      >

      <input-text-area
        v-model="userData['message']"
        :required="true"
        placeholder="Enter your query here"
        >Message:
      </input-text-area>

      <div class="form-checkbox-group">
        <input-checkbox v-model="userData['checkboxSubscribe']">
          I want to subscribe to the email list
        </input-checkbox>
        <input-checkbox
          v-model="userData['checkboxAcceptTerms']"
          :required="true"
        >
          I accept Terms & Conditions
        </input-checkbox>
        <input-checkbox v-model="userData['checkboxNotRobot']" :required="true">
          I am not a robot
        </input-checkbox>
      </div>

      <button type="submit" @click="beforeSubmit()">Submit</button>
    </form>

    <div class="debug">
      <h2>This userData gets sent to PHP</h2>
      <pre>
        <code>{{ userData }}</code>
        <code>Endpoint:{{endpoint}}</code>
        </pre>
    </div>
  </div>
</template>

<script>
import InputText from "../components/InputText";
import InputCheckbox from "../components/InputCheckbox";
import InputRadio from "../components/InputRadio";
import InputTextArea from "../components/InputTextArea";

export default {
  name: "ContactUs",
  props: {
    endpoint: String,
  },
  components: {
    InputText,
    InputCheckbox,
    InputRadio,
    InputTextArea,
  },
  data: function () {
    return {
      userData: {
        "first name": null,
        "last name": null,
        email: null,
        company: null,
        department: null,
        "subject line": null,
        message: null,
        checkboxNotRobot: false,
        checkboxAcceptTerms: false,
        checkboxSubscribe: false,
      },
      errors: [],
    };
  },
  methods: {
    submitToPHP() {
      this.axios
        .post(this.endpoint + "vue-contact-us-submit.php", this.userData)
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
      if (!this.isAllRequiredFilled(this.userData)) return;

      console.log("being sent", this.userData);

      // Submit the userData
      this.submitToPHP();
    },
    isEmailCorrect(email) {
      // yoinked from https://stackoverflow.com/a/9204568/4096078
      const re = /\S+@\S+\.\S+/;
      return re.test(email);
    },
    scrollToError() {
      this.$el.querySelector("#form").scrollIntoView({ behavior: "smooth" });
    },
    isAllRequiredFilled(data) {
      this.errors = [];

      // TODO: Jump to error code

      // Copy the object to mutate safely
      // then get rid of elements that are not required.
      let mutableData = Object.assign({}, data);
      delete mutableData["company"];
      delete mutableData["checkboxSubscribe"];

      // validate email
      if (!this.isEmailCorrect(mutableData["email"])) {
        this.errors.push("The email does not look correct");
      }

      // check the object and add to errors
      for (const key in mutableData) {
        console.log("inside mutableData", key);

        // If the key value is empty/null OR an empty string
        if (!mutableData[key]) {
          // Make the first letter capital
          const prettierWord = key[0].toUpperCase() + key.substring(1);

          // if it contains the checkbox text, give it a custom error
          if (key.includes("checkboxNotRobot")) {
            this.errors.push("You must confirm that you are not a robot");
          } else if (key.includes("checkboxAcceptTerms")) {
            this.errors.push("You must accept the terms");
          } else {
            this.errors.push(prettierWord + " cannot be empty");
          }
        }
      }

      // If there's any errors, jump to the error messages and return false
      if (this.errors.length) {
        this.scrollToError();

        return false;
      } else {
        return true;
      }
    },
  },
};
</script>

<style lang="scss">
#form {
  scroll-margin-top: 20ex;
}

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
