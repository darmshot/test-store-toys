<template>
    <el-form :label-position="labelPosition" label-width="100px" :model="form" ref="dynamicValidateForm">
        <div>
            Ваши данные
        </div>
        <el-form-item label="Имя" prop="name" :rules="[
                        {required:true,message:'Пожалуйста введите Имя'}
        ]">
            <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="Телефон" prop="telephone" :rules="[
            {required:true,message:'Пожалуйста введите Телефон'}
        ]">
            <el-input v-model="form.telephone"></el-input>
        </el-form-item>
        <el-form-item label="Email"
                      prop="email"
                      :rules="[
      { required: true, message: 'Пожалуйста введите Email адрес', trigger: 'blur' },
      { type: 'email', message: 'Пожалуйста введите корректный Email адрес', trigger: ['blur', 'change'] }
    ]">
            <el-input v-model="form.email"
            ></el-input>
        </el-form-item>
        <div>
            Способ доставки
        </div>
        <el-form-item>
            <el-radio-group v-model="form.delivery">
                <el-radio label="Самовывоз"></el-radio>
                <el-radio label="Доставка курьером"></el-radio>
            </el-radio-group>
        </el-form-item>
        <div>
            Способ оплаты
        </div>
        <el-form-item>
            <el-radio-group v-model="form.payment">
                <el-radio label="Наличными"></el-radio>
                <!--                <el-radio label="Venue"></el-radio>-->
            </el-radio-group>
        </el-form-item>
        <div>
            Комментарий
        </div>
        <el-form-item>
            <el-input type="textarea" v-model="form.comment"
                      maxlength="250"
                      show-word-limit
                      rows="3"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitForm('dynamicValidateForm')">Оформить заказ</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: "CheckoutForm",
    data() {
        return {
            labelPosition: 'top',
            form: {
                name: '',
                telephone: '',
                email: '',
                comment: '',
                payment: 'Наличными',
                delivery: 'Самовывоз'
            }
        };
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    console.log('form valid!')
                this.$store.dispatch('checkout/handleConfirm',this.form)
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
    }
})
</script>

<style scoped>

</style>
