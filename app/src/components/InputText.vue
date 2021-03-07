<template>
  <div class="form-input">
    <label :for="inputID"><slot></slot><span v-show="required" class="red">*</span></label>

      <input
        v-bind="$attrs"
        :id="inputID"
        :value="modelValue"
        :placeholder="placeholder"
        :class="className"
        @input="$emit('update:modelValue', $event.target.value)"
      />
  </div>

</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: "",
    },
    modelValue: {
      type: [String, Number],
      default: "",
    },
    placeholder: {
      type: [String],
      default: "",
    },
    className: {
      type: [String],
      default: "",
    },
    required: {
      type: [Boolean],
      default: false,
    },
    inputID: {
        type: [String],
        default: "1"
    }
  },
};

// export default {
//     props: ['dataName', 'placeholder', 'required'],
//     data() {
//         return {
//             content: this.value

//         }
//     },
//     methods: {
//         handleInput (e) {
//             console.log("handling!", e);
//             this.$emit('input', this.content);
//         }
//     }
// }
</script>
