const { createApp } = Vue;

createApp({
  data() {
    return {
      // Screen controls
      ShowUserBoot: true,
      ShowUserMenu: false,
      ShowUserRequest: false,
      ShowServiceSuccess: false,
      ShowTrackRequest: false,
      ShowRequestDetails: false,
      ShowAdmissionForm: false,

      // Form fields
      firstName: '',
      firstNameReq: '',
      middleName: '',
      lastName: '',
      lastNameReq: '',
      extension: '',
      dateOfBirth: '',
      lrn: '',
      homeAddress: '',
      email: '',
      emailReq: '',
      documentType: '',
      purpose: '',
      lrnMessage: 'This field is required.',
      
      //fields Validation Admission
      firstNameField: false,
      lastNameField: false,
      dateOfBirthField: false,
      lrnField: false,
      homeAddressField: false,
      emailField: false,
      currentDate: new Date().toISOString().split('T')[0],
      
      //fields Validation Request
      firstNameReqField: false,
      lastNameReqField: false,
      emailReqField: false,
      purposeReqField: false,

      // Validation
      submitted: false,
    };
  },
  mounted() {
    setTimeout(() => {
      this.goToMenu();
    }, 2000);
  },
  methods: {
    goToMenu() {
      this.resetScreens();
      this.ShowUserMenu = true;
    },
    goToAdmissionForm() {
      this.resetScreens();
      this.ShowAdmissionForm = true;
    },
    goToRequestForm() {
      this.resetScreens();
      this.ShowUserRequest = true;
    },
    submitRequest() {
      this.submitted = true;
      this.firstNameReqField = this.firstNameReq ? true : false;
      this.lastNameReqField = this.lastNameReq ? true : false;
      this.emailReqField = (this.emailReq && this.isEmailValid(this.emailReq)) ? true : false;
      this.purposeReqField = this.purposeReq ? true : false;

      if (
        this.firstNameReqField &&
        this.lastNameReqField &&
        this.documentType &&
        this.purposeReqField &&
        this.emailReqField &&
        this.isEmailValid(this.emailReq)

      ) {
        alert('Request submitted successfully!');
        this.resetScreens();
        this.ShowServiceSuccess = true;

        // Reset form (optional)
        this.firstName = '';
        this.middleName = '';
        this.lastName = '';
        this.extension = '';
        this.email = '';
        this.documentType = '';
        this.purpose = '';
        this.submitted = false;
      }
    },
    trackRequest() {
      this.resetScreens();
      this.ShowTrackRequest = true;
    },
    showRequestDetails() {
      this.resetScreens();
      this.ShowRequestDetails = true;
    },
    resetScreens() {
      this.ShowUserBoot = false;
      this.ShowUserMenu = false;
      this.ShowUserRequest = false;
      this.ShowServiceSuccess = false;
      this.ShowTrackRequest = false;
      this.ShowRequestDetails = false;
      this.ShowAdmissionForm = false;
    },

    isEmailValid(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },
    isNumeric(event) {
      this.lrn = event.target.value.replace(/\D/g, '').slice(0, 12);
    },
    isLrnValid() {
      if (this.lrn && this.lrn.length !== 12) {
        this.lrnField = false;
        this.lrnMessage = "Please enter a valid lrn";
      }
    },
    validateAdmissionForm() {
      this.submitted = true;

      this.firstNameField = this.firstName ? true : false;
      this.lastNameField = this.lastName ? true : false;
      this.dateOfBirthField = this.dateOfBirth ? true : false;
      this.lrnField = this.lrn ? true : false;
      this.homeAddressField = this.homeAddress ? true : false;
      this.emailField = (this.email && this.isEmailValid(this.email)) ? true : false;
      this.isLrnValid()
      if (
        this.firstNameField &&
        this.lastNameField &&
        this.dateOfBirthField &&
        this.lrnField &&
        this.homeAddressField &&
        this.emailField &&
        this.isEmailValid(this.email)
      ) {
        this.resetScreens();
        this.ShowServiceSuccess = true;
        this.ShowAdmissionForm = false;
        this.firstName = '';
        this.middleName = '';
        this.lastName = '';
        this.extension = '';
        this.email = '';
      }
    }



  }
}).mount('#app');
