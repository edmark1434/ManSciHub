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
      ShowDocumentRequests: true,
      ShowSchoolAdmissions: false,
      ShowAdministrators: false,
      ShowStudents: false,
      ShowAuditLogByAdmin: false,
      ShowAuditLogAll: false,
      ShowAdminControls: false,
      ShowDocumentTypes: false,

      ShowRequestPopup: false,
      ShowAdmissionPopup: false,
      ShowAdminPopup: false,
      ShowDocTypePopup: false,
      ShowAreYouSurePopup: false,
      ShowUsernameChange: false,
      ShowPasswordChange: false,
      ShowPasswordConfirm: false,
      ShowAdminCreatePopup: false,
      ShowDocTypeRenamePopup: false,
      ShowDocTypeCreatePopup: false,
      ShowLoading: false,

      AdminID: 0,
      hmm: false,

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
      createAdminUsername: '',
      createAdminPassword: '',
      confirmPassword: '',
      confirmPasswordIncorrect: false,
      checkUsername: false,
      lrnReq: '',
      homeAddress: '',
      email: '',
      emailReq: '',
      purpose: '',
      admissionLevel: '',
      trackID: '',
      status: '',
      loginFailed: '',
      documentType: '',
      docType: {},
      request: {},
      requestTrack: null,
      admission: {},
      requestDetail: {},
      admissionResponse: {},
      adminDetails: {},
      requestTrackMessage: '',
      lrnMessage: 'This field is required.',
      emailMessage: 'This field is required.',
      lrnReqMessage: 'This field is required.',
      emailReqMessage: 'This field is required.',
      firstNameMessage: 'This field is required.',
      loadingMessage: 'Loading Changes....',

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
      verified: false,
      documentExist: false,

      // today
      today: new Date().toISOString().split('T')[0],

      // lists for admin panel
      activerequestslist: [],
      archivedrequestslist: [],

      activeadmissionslist: [],
      archivedadmissionslist: {},

      // requestslist: [],
      // admissionslist: [],
      adminslist: [],
      studentslist: [],
      auditslist: [],
      doctypeslist: [],
      controls: [],

      // focus objects
      focusrequest: {},
      focusadmission: {},
      focusadmin: {},
      focusstudent: {},
      focusaudit: {},
      focusdoctype: {},

      // sorting and filtering
      requestsort: 'req_date',
      requestorder: 'desc',
      requestview: 'current',
      requestshowpending: true,
      requestshowready: true,
      requestshowrejected: false,
      requestshowretrieved: false,

      admissionsort: 'adms_date',
      admissionorder: 'desc',
      admissionview: 'current',
      admissionshowpending: true,
      admissionshowrejected: true,
      admissionshowwaitlisted: true,
      admissionshowaccepted: true,

      studentsort: 'stud_lname',
      studentorder: 'asc',
    };
  },
  mounted() {
    setTimeout(() => {
      this.goToMenu();
    }, 2000);
    fetch.getAllDocuments().then((data) => {
      this.docType = data.filter(doc => doc.docu_is_active);
    });
  },
  methods: {
    resetAdminScreens() {
            // Admin Panel Screens
      this.ShowDocumentRequests = false;
      this.ShowSchoolAdmissions= false;
      this.ShowAdministrators= false;
      this.ShowStudents= false;
      this.ShowAuditLogByAdmin= false;
      this.ShowAuditLogAll= false;
      this.ShowAdminControls= false;
      this.ShowDocumentTypes= false;

      this.ShowRequestPopup= false;
      this.ShowAdmissionPopup= false;
      this.ShowAdminPopup= false;
      this.ShowDocTypePopup= false;
      this.ShowAreYouSurePopup= false;
      this.ShowUsernameChange= false;
      this.ShowPasswordChange= false;
      this.ShowPasswordConfirm= false;
      this.ShowAdminCreatePopup= false;
      this.ShowDocTypeRenamePopup= false;
      this.ShowDocTypeCreatePopup= false;
      this.ShowLoading= false;
    },
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
    showConfirmPassword() {
      this.checkUsername = false;
      const exists = Object.values(this.adminslist).some(
      admin => admin.admin_username === this.adminUsername);
      if (exists) {
        this.checkUsername = true;
      } else {
        this.ShowAdminCreatePopup = false;
        this.ShowPasswordConfirm = true;
      }
    },
    loadingScreenTimeout() {
      setTimeout(() => {
        this.ShowLoading = false;
        this.adminUsername = '';
        this.adminPassword = '';
        this.documentType = '';
      },3000);
    },
    async documentCreate() {
      const documentObject = {
        "docu_type" : this.documentType
      }
      this.documentExist = false;
      const exists = Object.values(this.docType).some(
        document => document.docu_type === this.documentType);
      if (exists) {
        this.documentExist = true;
      } else {
        const data = await send.documentCreate(documentObject);
        fetch.getAllDocuments().then((docu_data) => {
          this.docType = docu_data;
        });
        this.resetAdminScreens();
        this.ShowLoading = true;
        this.loadingMessage = data +" "+this.documentType;
        this.loadingScreenTimeout();
        this.ShowDocumentTypes = true;
      }
    },
    async createAdmin() {
      this.confirmPasswordIncorrect = false;
      if (this.confirmPassword === this.adminPassword) {
        const adminObject = {
          "admin_fname": "Jodeci",
          "admin_lname": "Pacibe",
          "admin_username": this.createAdminUsername,
          "admin_password": this.createAdminPassword
        };
        const data = await send.CreateAdmin(adminObject);
        this.getAllAdmin();
        this.resetAdminScreens();
        this.ShowLoading = true;
        this.loadingMessage = data + this.createAdminUsername;
        this.loadingScreenTimeout();
        this.ShowAdministrators = true;
      } else {
        this.confirmPasswordIncorrect = true;
      }
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
    async getAllAdmission(){
      const data = await fetch.getAllAdmission();
      this.activeadmissionslist = data.data;
    },
    async getAllAdmissionHistory(){
      const data = await fetch.getAllAdmissionHistory();
      this.archivedadmissionslist = data.data;
    },
    async getAllRequest(){
      const data = await fetch.getAllRequest();
      this.activerequestslist = data.data;
    },
    async getAllRequestHistory(){
      const data = await fetch.getAllRequestHistory();
      this.archivedrequestslist = data.data;
    },
    async getAllStudent() {
      const data = await fetch.getAllStudent();
      this.studentslist = data.data;
    },
    async getAllAdmin() {
      const data = await fetch.getAllAdmin();
      this.adminslist = data.data.filter(admin => admin.admin_is_active);
    },
    async getAllChangeHistory() {
      const data = await fetch.getAllChangeHistory();
      this.auditslist = data.data;
    },
    async checkLogin() {
      this.submitted = true;
      this.login = true;
      if (this.username && this.password) {
        const loginObject = {
          username: this.username,
          password: this.password
        };
        let data = await send.AdminLogin(loginObject);
        if (data.data) {
          this.login = true;
          this.loginMessage = data.message;
          this.adminDetails = data.data;
          this.verified = true;
          this.AdminID = data.data.admin_id;
          this.getAllAdmission();
          this.getAllRequest();
          this.getAllStudent();
          this.getAllAdmin();
          this.getAllChangeHistory();
          this.resetScreens();
          this.ShowAdminPanel = true;
        } else {
          this.login = false;
          this.loginMessage = "Invalid Credentials. Access denied!";
        }
      } else {
        this.loginMessage = "Please enter username or password!";
      }
    },
    
    async submitRequest() {
      this.submitted = true;
      this.emailReqMessage = !this.emailReq ? 'This field is required.' : !this.isEmailValid(this.emailReq) ? 'Please enter valid email' :'';
      this.lrnReqMessage = !this.lrnReq ? 'This field is required.' : '';
      this.firstNameReqField = this.firstNameReq ? true : false;
      this.lastNameReqField = this.lastNameReq ? true : false;
      this.emailReqField = (this.emailReq && this.isEmailValid(this.emailReq)) ? true : false;
      this.purposeReqField = this.purpose ? true : false;
      this.lrnReqField = this.lrnReq ? true : false;
      this.isLrnValid();
      if (this.lrnReqField && this.emailReqField) {
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
      this.resetFormValidation();
    },
    isEmailValid(email) {
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
      if(this.lrn || this.lrnReq){
        if ((this.lrn.length !== 12) || ( this.lrnReq.length !== 12)) {
        this.lrnField = false;
        this.lrnReqField = false;
        this.lrnMessage = "Please enter a valid lrn";
        this.lrnReqMessage = "Please enter a valid lrn";
        } else {
        this.lrnField = true;
        this.lrnReqField = true;
        }
      }
    },
    async validateAdmissionForm() {
      let response = {};
      this.submitted = true;
      this.firstNameMessage = 'This field is required.';
      this.emailMessage = !this.email ? 'This field is required.' : !this.isEmailValid(this.email) ? 'Please enter valid email' :'';
      this.lrnMessage = !this.lrn ? 'This field is required.' : '';
      this.firstNameField = this.firstName ? true : false;
      this.lastNameField = this.lastName ? true : false;
      this.dateOfBirthField = this.dateOfBirth ? true : false;
      this.lrnField = this.lrn ? true : false;
      this.homeAddressField = this.homeAddress ? true : false;
      this.emailField = (this.email && this.isEmailValid(this.email)) ? true : false;
      this.isLrnValid();
      if (this.emailField && this.lrnField) {
        this.admissionResponse = await send.AdmissionRequest(this.admissionObject());
        response = this.admissionResponse.data;
        const responseMessage = this.admissionResponse.message.toLowerCase();
        if (!response) {
          if (responseMessage.includes('email')) {
            this.emailField = false;
            this.emailMessage = responseMessage;
          }
          if (responseMessage.includes('lrn')) {
            this.lrnField = false;
            this.lrnMessage = responseMessage;
          }
          if (responseMessage.includes('student')) {
            this.firstNameField = false;
            this.firstNameMessage = responseMessage;
          }
        }
      }
      if (
          this.firstNameField &&
          this.lastNameField &&
          this.dateOfBirthField &&
          this.lrnField &&
          this.homeAddressField &&
          this.admissionLevel &&
          this.emailField
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
      this.lrnReq = '';
      this.homeAddress= '';
      this.email= '';
      this.emailReq= '';
      this.documentType= '';
      this.purpose= '';
      this.admissionLevel = '';
      this.username = '';
      this.password = '';
      this.adminUsername = '';
      this.adminPassword = '';
      this.confirmPassword = '';
      this.lrnField = false;
      this.lrnReqField = false;
      this.emailMessage = 'this field is required.';
      this.lrnMessage = 'This field is required.';
      this.emailReqMessage = 'This field is required.';
      this.lrnReqMessage = 'This field is required.';
      this.loginMessage = "";
      this.firstNameMessage = 'This field is required.';
    },

  },
  computed: {
    requestslist() {
      let final = [];
      if (requestview === 'current') {
        final = [...this.activerequestslist];
      } else if (requestview === 'archived') {
        final = [...this.archivedrequestslist];
      }

      final = final.sort((a, b) => {
        const valA = a[this.requestsort].toUpperCase();
        const valB = b[this.requestsort].toUpperCase();

        if (valA < valB) return this.requestorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.requestorder === 'asc' ? 1 : -1;
        return 0;
      });

      const filters = [];
      if (this.requestshowpending) filters.push(req => req.req_status.toUpperCase() === 'PENDING');
      if (this.requestshowready) filters.push(req => req.req_status.toUpperCase() === 'READY');
      if (this.requestshowrejected) filters.push(req => req.req_status.toUpperCase() === 'REJECTED');
      if (this.requestshowretrieved) filters.push(req => req.req_status.toUpperCase() === 'RETRIEVED');

      return final.filter(item =>
          filters.some(fn => fn(item)) // item passes if it matches ANY active filter
      );
    },
    admissionslist() {
      let final = [];
      if (requestview === 'current') {
        final = [...this.activeadmissionslist];
      } else {
        final = [...(this.archivedadmissionslist[this.requestview])];
      }

      final = final.sort((a, b) => {
        const valA = a[this.admissionsort].toUpperCase();
        const valB = b[this.admissionsort].toUpperCase();

        if (valA < valB) return this.admissionorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.admissionorder === 'asc' ? 1 : -1;
        return 0;
      });

      const filters = [];
      if (this.admissionshowpending) filters.push(adm => adm.adm_status.toUpperCase() === 'PENDING');
      if (this.admissionshowrejected) filters.push(adm => adm.adm_status.toUpperCase() === 'REJECTED');
      if (this.admissionshowwaitlisted) filters.push(adm => adm.adm_status.toUpperCase() === 'WAITLISTED');
      if (this.admissionshowaccepted) filters.push(adm => adm.adm_status.toUpperCase() === 'ACCEPTED');

      return final.filter(item =>
          filters.some(fn => fn(item)) // item passes if it matches ANY active filter
      );
    },
    studentslist() {
      const final = [...this.studentslist];

      return final.sort((a, b) => {
        const valA = a[this.studentsort];
        const valB = b[this.studentsort];

        if (valA < valB) return this.studentorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.studentorder === 'asc' ? 1 : -1;
        return 0;
      });
    },
    auditslist() {
      // oten
    },
  }
}).mount('#app');
