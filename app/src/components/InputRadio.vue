<template>
    <div class="form-radio">
      <input
        type="radio"
        v-bind="$attrs"
        :id="elementID"
        :class="className"
        :value="value"
        :checked="modelValue === value"
        @change="$emit('update:modelValue', value)"
      />
      <label :for="elementID"><slot></slot><span v-if="required" class="red">*</span></label>

    </div>

</template>

<script>
import { v4 as uuidv4 } from 'uuid';

export default {
    props: {
        modelValue: {
            type: [String, Number],
            default: ''
        },
        value: {
            type: [String, Number],
            required: true
        },
        required: {
            type: Boolean,
            default: false
        },
        inputID: {
            type: [String, Number],
            default: uuidv4()
        },
        className: {
            type: String,
            default: ''
        }
    },
 data: function () {
    return {
      elementID: 0
    }
 },
 mounted() {
    console.log("MOUNT ME")
     if (this.inputID) {
         console.log("already has ID")
         this.elementID = this.inputID;
     } else {
         this.elementID = uuidv4();
         console.log("random me", this.elementID)
     }
 }
}

</script>
