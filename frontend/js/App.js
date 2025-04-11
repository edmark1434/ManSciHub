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
      trackID: '',

      // Validation
      submitted: false,
    };
  },
  mounted() {
    setTimeout(() => {
      this.goToMenu();
    }, 3000);
  },
  methods: {
    goToMenu() {
      this.resetScreens();
      this.resetFormValidation();  // Reset validation (red borders) when going to menu
      this.ShowUserMenu = true;
    },
    goToAdmissionForm() {
      this.resetScreens();
      this.resetAdmissionForm();
      this.ShowAdmissionForm = true;
    },
    resetAdmissionForm() {
      this.submitted = false;
      this.firstName = '';
      this.middleName = '';
      this.lastName = '';
      this.extension = '';
      this.dateOfBirth = '';
      this.lrn = '';
      this.homeAddress = '';
      this.email = '';
      this.documentType = '';
    },
    goToRequestForm() {
      this.resetScreens();
      this.resetFormValidation();  // Reset validation (red borders) when going to request form
      this.ShowUserRequest = true;
    },
    submitTrackID() {
      this.submitted = true;
      if (this.trackID) {
        alert('Tracking request!');
        this.resetScreens();
        this.ShowRequestDetails = true;
      }
    },
    submitRequest() {
      this.submitted = true;

      if (
        this.firstName &&
        this.lastName &&
        this.documentType &&
        this.purpose &&
        this.lrn &&
        (this.email === '' || this.isEmailValid())
      ) {
        alert('Request submitted successfully!');
        this.resetScreens();
        this.ShowServiceSuccess = true;

        // Reset form (optional)
        this.resetFormValidation();  // Reset form after successful submission
      }
    },
    trackRequest() {
      this.resetScreens();
      this.submitted = false; // Clear validation state
      this.trackID = '';      // Clear input field
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
        this.ShowServiceSuccess = true;
        // Do actual submit or switch screen
      }
    },

    // Reset the validation state (red borders) and form fields
    resetFormValidation() {
      this.submitted = false;  // Remove red error borders
      this.firstName = '';
      this.middleName = '';
      this.lastName = '';
      this.extension = '';
      this.dateOfBirth = '';
      this.lrn = '';
      this.homeAddress = '';
      this.email = '';
      this.documentType = '';
      this.purpose = '';
    }
  }
}).mount('#app');
