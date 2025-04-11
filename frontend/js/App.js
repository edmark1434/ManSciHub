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
      middleName: '',
      lastName: '',
      extension: '',
      dateOfBirth: '',
      lrn: '',
      homeAddress: '',
      email: '',
      documentType: '',
      purpose: '',


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

      if (
        this.firstName &&
        this.lastName &&
        this.documentType &&
        this.purpose &&
        (this.email === '' || this.isEmailValid())
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

    isEmailValid() {
      return (
        this.email === '' ||
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)
      );
    },

    validateAdmissionForm() {
      this.submitted = true;

      if (
        this.firstName &&
        this.lastName &&
        this.dateOfBirth &&
        this.lrn &&
        this.homeAddress &&
        this.isEmailValid()
      ) {
        alert('Form submitted successfully!');
        this.resetScreens();
        this.ShowUserMenu = true;
        // Do actual submit or switch screen
      }
    }



  }
}).mount('#app');
