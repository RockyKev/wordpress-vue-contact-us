<template>
     <div class="form-textarea">
        <!-- <label for="userMessage">Message<span class="red">*</span>:</label> -->
        <label :for="inputID"><slot></slot><span v-if="required" class="red">*</span></label>

        <textarea
        v-bind="$attrs"
        :id="inputID"
        :placeholder="placeholder"
        :class="className"
        @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
      </div>
</template>

<script>
import { v4 as uuidv4 } from 'uuid';

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
      type: String,
      default: "",
    },
    className: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: false,
    },
    inputID: {
        type: String,
        default: uuidv4()
    }
  },
};
</script>
