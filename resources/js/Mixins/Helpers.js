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
            let num = this.convertToTwoDecimalPlaces(number)
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        },
        
        convertToTwoDecimalPlaces(numStr) {
            const num = parseFloat(numStr);
            if (isNaN(num)) {
                return NaN;
            }
            return num.toFixed(2);  
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
        },
        
        removeDashes(str) {
            console.log(str);
            return str.replace(/_/g, " ");
        },

        //removing dashes and capitalize
        removeDashesAndcapitalize(str) {
            return  str.replace(/_/g, ' ').replace(/(\w+)/g, (match) => match.charAt(0).toUpperCase() + match.slice(1))
        },

         // number of days added date
        addDays(dateString, days) {
            return moment(dateString).add(days, 'days').format("Do MMM YYYY").toDate();
        },

        //scroll to top of page
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    }
}