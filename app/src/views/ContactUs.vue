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

      <input-text
        v-model="data['first name']"
        type="Text"
        :required="true"
        placeholder="Paul"
        >First Name:</input-text
      >

      <input-text
        v-model="data['last name']"
        type="Text"
        :required="true"
        placeholder="Rudd"
        >Last Name:</input-text
      >

      <input-text
        v-model="data['email']"
        type="Email"
        :required="true"
        placeholder="theemail@website.com"
        >Email:</input-text
      >

      <input-text
        v-model="data['company']"
        type="Text"
        :required="true"
        placeholder="Macrosoft"
        >Company:</input-text
      >

      <!-- TODO: All IDs are shared. They need to be refreshed -->
      <div class="form-radio-group">
        <p>Department<span class="red">*</span>:</p>
        <input-radio
          v-model="data['department']"
          value="department123"
          :inputID="butts"
          >Customer Service</input-radio
        >

        <input-radio
          v-model="data['department']"
          value="departmentIT"
          :inputID="nuutts"
          >IT Issue</input-radio
        >

        <input-radio v-model="data['department']" value="departmentBill"
          >Billing</input-radio
        >
      </div>

      <input-text
        v-model="data['subject line']"
        type="Text"
        :required="true"
        placeholder="Reaching out for help"
        >Email Subject Line:</input-text
      >

      <input-text-area
        v-model="data['message']"
        :required="true"
        placeholder="Enter your query here"
        >Message:
      </input-text-area>

      <div class="form-checkbox-group">
        <input-checkbox v-model="data['checkboxSubscribe']">
          I want to subscribe to the email list
        </input-checkbox>
        <input-checkbox v-model="data['checkboxAcceptTerms']" :required="true">
          I accept Terms & Conditions
        </input-checkbox>
        <input-checkbox v-model="data['checkboxNotRobot']" :required="true">
          I am not a robot
        </input-checkbox>
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
      data: {
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

      console.log("being sent", this.data);

      // Submit the Data
      this.submitToPHP();
    },
    isEmailCorrect(email) {
      // yoinked from https://stackoverflow.com/a/9204568/4096078
      const re = /\S+@\S+\.\S+/;
      return re.test(email);
    },
    isAllRequiredFilled(data) {
      this.errors = [];

      // TODO: Jump to error code

      // Copy the object to mutate safely
      // then get rid of non-neccessary data
      let mutableData = Object.assign({}, data);
      delete mutableData["company"];

      // check the object and add to errors
      for (const key in mutableData) {
        if (Array.isArray(mutableData[key])) break;

        if (mutableData[key] == null || mutableData[key].trim() == "") {
          const prettierWord = key[0].toUpperCase() + key.substring(1);
          this.errors.push(prettierWord + " cannot be empty");
        }
      }

      // validate email
      if (!this.isEmailCorrect(mutableData["email"])) {
        this.errors.push("The email does not look correct");
      }

      // check if checkbox Values exist
      if (!mutableData.checkboxValues.includes("acceptTerms")) {
        this.errors.push("You must accept the terms");
      }

      if (!mutableData.checkboxValues.includes("notRobot")) {
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
