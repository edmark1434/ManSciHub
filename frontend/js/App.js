const { createApp } = Vue;
import * as fetch from "./fetch.js";
import * as send from "./send.js";

createApp({
  data() {
    return {
      // Screen controls
      ShowUserBoot: true,
      ShowAdminBoot: false,
      ShowAdminLogin: false,
      ShowUserMenu: false,
      ShowUserRequest: false,
      ShowServiceAdmissionSuccess: false,
      ShowServiceRequestSuccess: false,
      ShowTrackRequest: false,
      ShowRequestDetails: false,
      ShowAdmissionForm: false,

      // Form Fields
      // Form fields
      username: '',
      password: '',
      firstName: '',
      firstNameReq: '',
      middleName: '',
      middleNameReq: '',
      lastName: '',
      lastNameReq: '',
      extension: '',
      extensionReq: '',
      dateOfBirth: '',
      lrn: '',
      lrnReq: '',
      homeAddress: '',
      email: '',
      emailReq: '',
      documentType: '',
      purpose: '',
      admissionLevel: '',
      trackID: '',
      status: '',
      loginFailed: '',
      emailResult: false,
      lrnResult: false,
      docType: {},
      request: {},
      requestTrack: null,
      admission: {},
      requestDetail: {},
      admissionResponse: {},
      userDetails: {},
      lrnMessage: 'This field is required.',
      emailMessage: 'This field is required.',
      lrnReqMessage: 'This field is required.',
      emailReqMessage: 'This field is required.',
      
      //fields Validation Admission
      firstNameField: false,
      lastNameField: false,
      dateOfBirthField: false,
      lrnField: false,
      homeAddressField: false,
      emailField: false,
      currentDate: new Date().toISOString().split('T')[0],
      
      //fields Validation Request
      errorStatus: false,
      firstNameReqField: false,
      lastNameReqField: false,
      emailReqField: false,
      lrnReqField: false,
      purposeReqField: false,

      // Validation
      submitted: false,

      //admin login validation
      login: false,
      loginMessage: '',
      verified : false,
    };
  },
  mounted() {
    setTimeout(() => {
      this.goToMenu();
    }, 2000);
    fetch.getAllDocuments().then((data) => {
      this.docType = data;
    });
  },
  methods: {
    requestObject() {
      this.request["stud_fname"] = this.firstNameReq;
      this.request["stud_lname"] = this.lastNameReq;
      this.request["stud_mname"] = this.middleNameReq;
      this.request["stud_suffix"] = this.extensionReq;
      this.request["stud_lrn"] = this.lrnReq;
      this.request["stud_email"] = this.emailReq;
      this.request["req_purpose"] = this.purpose;
      this.request["docu_id"] = this.documentType;
      return this.request;
    },  
    admissionObject() {
      this.admission["stud_fname"] = this.firstName;
      this.admission["stud_lname"] = this.lastName;
      this.admission["stud_mname"] = this.middleName;
      this.admission["stud_suffix"] = this.extension;
      this.admission["stud_lrn"] = this.lrn;
      this.admission["stud_email"] = this.email;
      this.admission["stud_add"] = this.homeAddress;
      this.admission["stud_dob"] = this.dateOfBirth;
      this.admission["adms_lvl"] = this.admissionLevel;
      return this.admission;
    }, 
    goToMenu() {
      this.resetScreens();
      this.ShowUserMenu = true;
      this.request = {};
      this.admission = {};
      this.requestDetail = {};
      this.admissionResponse = {};
      this.errorStatus = false;
      this.requestTrack = null;
    },
    goToAdmissionForm() {
      this.resetScreens();
      this.ShowAdmissionForm = true;
    },
    goToRequestForm() {
      this.resetScreens();
      this.ShowUserRequest = true;
    },
    submitTrackID() {
      this.submitted = true;
      if (this.trackID) {
        alert('Tracking request!');
          fetch.getRequestById(this.trackID).then((response) => {
            this.requestTrack = response.data.data;
            this.errorStatus = response.status;
          });
        this.resetScreens();
        this.ShowRequestDetails = true;
      }
    },
    async checkLogin() {
      const loginObject = {
        username: this.username,
        password: this.password
      }; 
      let data = await send.AdminLogin(loginObject);
      if (data.data) {
        this.login = true;
        this.loginMessage = data.message;
        this.userDetails = data.data;
        this.verified = true;
      } else {
        this.login = true;
        loginMessage = "Invalid Credentials.Access denied!";
      }
    },
    async checkEmail(entity) {
      let response = {};
      const object = {
        stud_email: entity
      };
      response = await send.getStudentByFilter(object);
      if (response.stud_id) {
        console.log(response);
        this.emailField = false;
        this.emailMessage = "Email already exists";
        return false;
      }
      return true;
    },
    async checkReqEmail(entity) {
      let response = {};
      const object = {
        stud_email: entity
      };
      response = await send.getStudentByFilter(object);
      if (response.stud_id) {
        console.log(response);
        this.emailReqField = false;
        this.emailReqMessage = "Email already exists";
        return false;
      }
      return true;
    },
    async checkLrn(entity) {
      let response = {};
      const object = {
        stud_lrn: entity
      };
      response = await send.getStudentByFilter(object);
      if (response.stud_id) {
        console.log(response);
        this.lrnField = false;
        this.lrnMessage = "LRN already exists";
        return false;
      }
      return true;
    },
    async checkReqLrn(entity) {
      let response = {};
      const object = {
        stud_lrn: entity
      };
      response = await send.getStudentByFilter(object);
      if (response.stud_id) {
        console.log(response);
        this.lrnReqField = false;
        this.lrnReqMessage = "LRN already exists";
        return false;
      }
      return true;
    },
    async submitRequest() {
      this.submitted = true;
      this.firstNameReqField = this.firstNameReq ? true : false;
      this.lastNameReqField = this.lastNameReq ? true : false;
      this.emailReqField = (this.emailReq && this.isEmailValid(this.emailReq)) ? true : false;
      this.purposeReqField = this.purpose ? true : false;
      this.lrnReqField = this.lrnReq ? true : false;
      this.isLrnValid();
      this.emailResult = await this.checkReqEmail(this.emailReq);
      this.lrnResult = await this.checkReqLrn(this.lrnReq);
      if (
        this.firstNameReqField &&
        this.lastNameReqField &&
        this.documentType &&
        this.purposeReqField &&
        this.emailReqField &&
        this.lrnReqField &&
        this.lrnResult &&
        this.emailResult &&
        this.isEmailValid(this.emailReq)
      ) {
        alert('Request submitted successfully!');
        this.requestDetail = await send.DocumentRequest(this.requestObject());
        this.resetScreens();
        this.requestDetail = this.requestDetail.data[0];
        this.ShowServiceRequestSuccess = true;
        this.resetFormValidation();
      }
    },
    trackRequest() {
      this.resetScreens();
      this.submitted = false; 
      this.trackID = '';     
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
      this.ShowServiceRequestSuccess = false;
      this.ShowServiceAdmissionSuccess = false;
      this.ShowTrackRequest = false;
      this.ShowRequestDetails = false;
      this.ShowAdmissionForm = false;
      this.firstNameField = false;
      this.lastNameField = false;
      this.dateOfBirthField = false;
        this.lrnField = false;
      this.homeAddressField = false;
          this.emailField = false;      
          //fields Validation Request
          this.errorStatus = false;
          this.firstNameReqField = false;
          this.lastNameReqField = false;
          this.emailReqField = false;
          this.lrnReqField = false;
      this.purposeReqField = false;
      this.verified = false;
      this.login = false;
      this.resetFormValidation();
    },
    isEmailValid(email) {
      this.emailMessage = "Please enter valid email";
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },
    async isNumeric(event) {
      const limit = event.target.value.replace(/\D/g, '').slice(0, 12);
      const trackLimit = event.target.value.replace(/\D/g, '').slice(0, 8);
      this.trackID = trackLimit;
      this.lrn = limit;
      this.lrnReq = limit;
    },
    isLrnValid() {
      if (this.lrn && this.lrn.length !== 12) {
        this.lrnField = false;
        this.lrnMessage = "Please enter a valid lrn";
      }
    },
    async validateAdmissionForm() {
      this.submitted = true;

      this.firstNameField = this.firstName ? true : false;
      this.lastNameField = this.lastName ? true : false;
      this.dateOfBirthField = this.dateOfBirth ? true : false;
      this.lrnField = this.lrn ? true : false;
      this.homeAddressField = this.homeAddress ? true : false;
      this.emailField = (this.email && this.isEmailValid(this.email)) ? true : false;
      this.emailResult = await this.checkEmail(this.email);
      this.lrnResult = await this.checkLrn(this.lrn);
      this.isLrnValid()
      if (
        this.firstNameField &&
        this.lastNameField &&
        this.dateOfBirthField &&
        this.lrnField &&
        this.homeAddressField &&
        this.admissionLevel &&
        this.emailField &&
        this.lrnResult &&
        this.emailResult
      ) {
        alert("success");
        this.admissionResponse = await send.AdmissionRequest(this.admissionObject());
        this.admissionResponse = this.admissionResponse.data[0];
        this.resetScreens();
        this.ShowServiceAdmissionSuccess = true;
        this.ShowAdmissionForm = false;
        this.resetFormValidation();
      }
    },
    resetFormValidation() {
      this.submitted = false;
      this.firstName = '';
      this.firstNameReq = '';
      this.middleName = '';
      this.middleNameReq = '';
      this.lastName= '';
      this.lastNameReq= '';
      this.extension= '';
      this.dateOfBirth= '';
      this.lrn= '';
      this.lrnReq= '';
      this.homeAddress= '';
      this.email= '';
      this.emailReq= '';
      this.documentType= '';
      this.purpose= '';
      this.admissionLevel = '';
      this.emailResult = false;
      this.lrnResult = false;
      this.emailMessage = 'Please input field';
      this.lrnMessage = 'Please input field';
      this.emailReqMessage = 'Please input field';
      this.lrnReqMessage = 'Please input field';
      this.loginMessage = "Invalid Credentials. Access denied!";
    }


  }
}).mount('#app');
