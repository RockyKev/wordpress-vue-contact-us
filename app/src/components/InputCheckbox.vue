<template>
    <div class="form-checkbox">
        <input
        :id="inputID"
        type="checkbox"
        :checked="modelValue"
        @change="$emit('update:modelValue', $event.target.checked)"
        class="field"
        />
        <label :for="inputID"><slot></slot><span v-if="required" class="red">*</span></label>
    </div>

</template>

<script>
import { v4 as uuidv4 } from 'uuid';

export default {
    props: {
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        inputID: {
            type: String,
            default: uuidv4()
        }
    }
}
</script>
