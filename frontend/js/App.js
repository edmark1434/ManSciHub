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
      ShowAdminPanel: false,

      // Admin Panel Screens
      ShowDocumentRequests: false,
      ShowSchoolAdmissions: false,
      ShowAdministrators: false,
      ShowStudents: false,
      ShowAuditLogByAdmin: false,
      ShowAuditLogAll: false,
      ShowAdminControls: false,

      ShowRequestPopup: false,
      ShowAdmissionPopup: false,
      ShowAdminPopup: false,
      ShowAreYouSurePopup: false,

      AdminID: 0,

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
      requestTrackMessage: '',
      lrnMessage: 'This field is required.',
      emailMessage: 'This field is required.',
      lrnReqMessage: 'This field is required.',
      emailReqMessage: 'This field is required.',

      // fields Validation Admission
      firstNameField: false,
      lastNameField: false,
      dateOfBirthField: false,
      lrnField: false,
      homeAddressField: false,
      emailField: false,
      currentDate: new Date().toISOString().split('T')[0],

      // fields Validation Request
      errorStatus: false,
      firstNameReqField: false,
      lastNameReqField: false,
      emailReqField: false,
      lrnReqField: false,
      purposeReqField: false,

      // Validation
      submitted: false,

      // admin login validation
      login: false,
      loginMessage: '',
      verified : false,

      // today
      today: new Date().toISOString().split('T')[0],

      // lists for admin panel
      requestslist: [],
      admissionslist: [],
      adminslist: [],
      studentslist: [],
      auditslist: [],
      controls: {}
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
    goToAdminLogin() {
      this.resetScreens();
      this.ShowAdminLogin = true;
    },
    async submitTrackID() {
      this.requestTrackMessage = '';
      this.submitted = true;
      if (this.trackID) {
        alert('Tracking request!');
        this.resetScreens();
        this.ShowRequestDetails = true;
        const response = await fetch.getRequestById(this.trackID); 
        this.requestTrack = response.data;
        if (!this.requestTrack) {
          this.errorStatus = true;
        }
      }
    },
    async checkLogin() {
      this.submitted = true;
      this.login = true;
      if (this.username && this.password) {
        if (this.username == '' || this.password == '') {
          this.loginMessage = "Invalid Credentials. Access denied!";
        }
        const loginObject = {
          username: this.username,
          password: this.password
        };
        let data = await send.AdminLogin(loginObject);
        if (data.data) {
          this.loginMessage = data.message;
          this.userDetails = data.data;
          this.verified = true;
          this.AdminID = data.data.admin_id;
        } else {
          this.login = true;
          this.loginMessage = "Invalid Credentials. Access denied!";
        }
      } else {
        this.loginMessage = "Please enter username or password!";
      }
    },
    
    async submitRequest() {
      this.submitted = true;
      this.firstNameReqField = this.firstNameReq ? true : false;
      this.lastNameReqField = this.lastNameReq ? true : false;
      this.emailReqField = (this.emailReq && this.isEmailValid(this.emailReq)) ? true : false;
      this.purposeReqField = this.purpose ? true : false;
      this.lrnReqField = this.lrnReq ? true : false;
      this.isLrnValid();
      const response = await send.DocumentRequest(this.requestObject());
      const responseMessage = response.message.toLowerCase();
      this.requestDetail = response.data;
      if (!this.requestDetail) {
        if (responseMessage.includes('email')) {
          this.emailReqField = false;
          this.emailReqMessage = responseMessage;
        }
        if (responseMessage.includes('lrn')) {
          this.lrnReqField = false;
          this.lrnReqMessage = responseMessage;
        }
      }
      if (
          this.firstNameReqField &&
          this.lastNameReqField &&
          this.documentType &&
          this.purposeReqField &&
          this.emailReqField &&
          this.lrnReqField &&
          this.isEmailValid(this.emailReq)
      ) {
        alert('Request submitted successfully!');
        this.requestDetail = this.requestDetail[0];
        this.resetScreens();
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
      this.ShowAdminBoot = false;
      this.ShowAdminLogin = false;
      this.ShowUserMenu = false;
      this.ShowUserRequest = false;
      this.ShowServiceAdmissionSuccess = false;
      this.ShowServiceRequestSuccess = false;
      this.ShowTrackRequest = false;
      this.ShowRequestDetails = false;
      this.ShowAdmissionForm = false;
      this.ShowAdminPanel = false;
      
      this.firstNameField = false;
      this.lastNameField = false;
      this.dateOfBirthField = false;
      this.lrnField = false;
      this.homeAddressField = false;
      this.emailField = false;

      //fields Validation Request
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
      if ((this.lrn || this.lrnReq ) && (this.lrn.length !== 12 || this.lrnReq.length !== 12)) {
        this.lrnField = false;
        this.lrnReqField = false;
        this.lrnMessage = "Please enter a valid lrn";
        this.lrnReqMessage = "Please enter a valid lrn";
      } else {
        this.lrnField = true;
        this.lrnReqField = true;
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
      this.isLrnValid();
      this.admissionResponse = await send.AdmissionRequest(this.admissionObject());
      const response = this.admissionResponse.data;
      const responseMessage = this.admissionResponse.message.toLowerCase();
      if (!response) {
        if (responseMessage.includes('email')) {
          this.emailField = false;
          this.emailReqMessage = responseMessage;
        }
        if (responseMessage.includes('lrn')) {
          this.lrnField = false;
          this.lrnMessage = responseMessage;
        }
      }
      if (
          this.firstNameField &&
          this.lastNameField &&
          this.dateOfBirthField &&
          this.lrnField &&
          this.homeAddressField &&
          this.admissionLevel &&
          this.emailField &&
          this.isEmailValid(this.email)
      ) {
        alert("success");
        this.admissionResponse = response[0];
        this.resetScreens();
        this.ShowServiceAdmissionSuccess = true;
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
      this.username = '';
      this.password = '';
      this.emailResult = false;
      this.lrnResult = false;
      this.emailMessage = 'Please input field';
      this.lrnMessage = 'Please input field';
      this.emailReqMessage = 'Please input field';
      this.lrnReqMessage = 'Please input field';
      this.loginMessage = "Invalid credentials. Access denied!";
    }


  }
}).mount('#app');
