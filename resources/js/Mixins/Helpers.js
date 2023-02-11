import moment from 'moment';
export default {
    methods: {
        // check user permissions
        checkUserPermissions(value) {
            const permissionsArray = this.$page.props.auth.user.permissions;

            // for single record
            if (typeof value == 'string') {
                return permissionsArray.includes(value);
            }

            // for array of permissions
            if (typeof value == 'object') {
                var result = false;
                value.forEach(element => {
                    let response = permissionsArray.includes(element);
                    if (response) {
                        return result = response;
                    }
                });
                return result;
            }
        },

        getImage($image) {
            return  $image ? $image : this.$page.props.settings.cover_placeholder
        },

        // formate time
        formatDate(dateString) {
            return moment(dateString).format("Do MMM YYYY");
        },

        //to formate amount formate
        formatNumber(number) {
            number = parseFloat(number)
            number.toFixed(2)
            return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        },

        //calculate tax
        calculateTax(amount, tax) {
            amount = parseFloat(amount)
            return (tax * amount) / 100
        },

        //get total
        getTotal(amount, tax) {
            amount = parseFloat(amount)
            tax = parseFloat(tax)
            return this.formatNumber(amount + tax)
        },

        // current date
        getCurrentDate() {
            return moment().format("DD-MM-YYYY");
        }
    }
}