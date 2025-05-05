const { createApp } = Vue;
import * as fetch from "./fetch.js";
import * as send from "./send.js";

createApp({
  data() {
    return {
      // Screen controls
      ShowUserBoot: true,
      ShowAdminBoot: false,
      ShowAdminSplash: false,
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
      documentTypeRename: '',
      documentMessage : '',
      lrn: '',
      createAdminUsername: '',
      createAdminPassword: '',
      createAdminFirstname: '',
      createAdminLastname: '',
      newAdminPassword: '',
      newAdminUsername: '',
      Process: '',
      confirmPassword: '',
      confirmPasswordIncorrect: false,
      checkUsername: false,
      checkPassword: false,
      checkDocument: false,
      lrnReq: '',
      homeAddress: '',
      email: '',
      emailReq: '',
      purpose: '',
      admissionLevel: '',
      trackID: '',
      status: '',
      loginFailed: '',
      fieldValidation: '',
      adminCreateMessage : '',
      documentType: '',
      documentRequestStatus: '',
      admissionRequestStatus: '',
      docType: {},
      request: {},
      requestTrack: null,
      interval : null,
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
      confirmPasswordMessage: '',
      adminBootMessage: '',

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
      isProcessing : false,
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
      adminslist: [],
      fullstudentslist: [],
      requestauditslist: [],
      admissionauditslist: [],
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
      showactiverequestfilters: true,

      requestsort: 'req_date',
      requestorder: 'desc',
      requestview: 'active',
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

      auditshowrequest: true,
      auditshowadmission: true,
      auditfilterdate: '',

      // searching
      requestsearchlive: '',
      admissionsearchlive: '',
      studentsearchlive: '',

      requestsearch: '',
      admissionsearch: '',
      studentsearch: '',

      // button texts
      loginButtonText: 'Login',
      passwordConfirmButtonText: 'Verify',
      documentRenameButtonText: 'Save changes',
    };
  },
  mounted() {
    setTimeout(() => {
      this.goToMenu();
    }, 2000);
      this.getAllDocuments();
      fetch.getAllDocuments().then((data) => {
        this.docType = data.filter(doc => doc.docu_is_active);
      });
  },
  beforeUnmount() {
    clearInterval(this.interval);
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
    intervalUpdate() {
      this.latestFetchRequest();
      this.interval = setInterval(() => {
        this.latestFetchRequest();
        this.getAllRequest();
      }, 90000);
    },
    async getAdminById() {
      const data = await fetch.getAdminById(this.focusadmin.admin_id);
      this.adminDetails = data.data;
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
    async latestFetchRequest() {
  if (this.isProcessing) return; 
  this.isProcessing = true;

  let data = await fetch.getRequestForms();
  const latestFetch = localStorage.getItem("latestFetch");

  if (latestFetch) {
    data = data.filter(d => new Date(d["Timestamp"]) > new Date(latestFetch));
  }

  if (data.length === 0) {
    console.log("No new requests.");
    this.isProcessing = false;
    return;
  }

  for (const req of data) {
    const timestamp = new Date(req["Timestamp"]);
    if (latestFetch && timestamp <= new Date(latestFetch)) {
      continue; // Already processed, skip this entry
    }
    const requestObject = {
      stud_fname:   req["First name"],
      stud_mname:   req["Middle name"],
      stud_lname:   req["Last name"],
      stud_suffix:  req["Extension"],
      stud_email:   req["Email address"],
      stud_lrn:     parseInt(req["Lrn"]),
      docu_id:      this.getDocumentID(req["Document Type"]),
      req_purpose:  req["Purpose of request"]
    };
    const emailObject = {
        "stud_fname": req['First name'],
        "stud_lname": req['Middle name'],
        "stud_mname": req['Last name'],
        "stud_suffix": req['Extension'],
        "stud_email": req['Email address'],
      };
    const res = await send.DocumentRequest(requestObject);

    if (res.message.includes("Email")) { 
      emailObject["email_subject"] = 'EMAIL';
      localStorage.setItem("latestFetch", req["Timestamp"]);
      this.EmailMessage(emailObject,"EMAIL");
    } 
    if (res.message.includes("Lrn")) {
      emailObject["email_subject"] = 'LRN';
      localStorage.setItem("latestFetch", req["Timestamp"]);
      this.EmailMessage(emailObject,"LRN");
    } 
    if (res.message.includes("Successfully")) {
      localStorage.setItem("latestFetch", req["Timestamp"]);
      console.log("Created OK")
    };
  }
  this.isProcessing = false;
},



    getDocumentID(document_name) {
      const data = this.docType.find(data => data.docu_type.trim().toLowerCase() === document_name.trim().toLowerCase());
      console.log(data);
      console.log(document_name);
      return data.docu_id;
    },
    async EmailMessage(object, Request) {
      const status = Request.toUpperCase();
      if (["READY", "REJECTED", "ACCEPTED", "LRN", "EMAIL"].includes(status)) {
        const data = await send.emailMessage(object);
        console.log(object.email_subject);
        console.log(data);
      }
    },
    async UpdateDocumentRequest(event) {
      const documentRequestObject = {
            "req_track_id": this.focusrequest.req_track_id,
            "req_date": this.focusrequest.req_date,
            "req_purpose": this.focusrequest.req_purpose,
            "req_status": this.documentRequestStatus,
            "docu_id": this.focusrequest.docu_id,
            "stud_id": this.focusrequest.stud_id
      };
      const emailObject = {
        "stud_fname": this.focusrequest.stud_fname,
        "stud_lname": this.focusrequest.stud_lname,
        "stud_mname": this.focusrequest.stud_mname,
        "stud_suffix": this.focusrequest.stud_suffix,
        "stud_email": this.focusrequest.stud_email,
        "email_subject" : "REQUEST "+this.documentRequestStatus.toUpperCase()
      };
      if (this.documentRequestStatus.toUpperCase() !== "REJECTED" && this.documentRequestStatus.toUpperCase() !== "ACCEPTED") {
        if (this.documentRequestStatus !== this.focusrequest.req_status) {
          event.currentTarget.textContent = "...";
          const data = await send.UpdateRequest(documentRequestObject);
          if (data.includes("Successfully")) {
          this.getAllRequest();
          this.getAllRequestHistory();
          this.resetAdminScreens();
          this.ShowLoading = true;
          this.loadingMessage = "Successfully Updated Request " + this.focusrequest.req_track_id;
          this.loadingScreenTimeout();
          this.ShowDocumentRequests = true;
          }
        }
        this.ShowRequestPopup = false;
        this.ShowDocumentRequests = true;
      } else {
        const data = await send.TransferRequest(documentRequestObject);
        if (data.includes("Successfully")) {
          this.getAllRequest();
          this.getAllRequestHistory();
          this.resetAdminScreens();
          this.ShowLoading = true;
          this.loadingMessage = "Successfully Updated Request " + this.focusrequest.req_track_id;
          this.loadingScreenTimeout();
          this.ShowDocumentRequests = true;
        }
      }
      this.EmailMessage(emailObject, this.documentRequestStatus);
    },
    async UpdateAdmissionRequest(event) {
      const admissionRequestObject = {
            "adms_id": this.focusadmission.adms_id,
            "adms_status" : this.admissionRequestStatus,
            "adms_date" : this.focusadmission.adms_date,
            "adms_lvl" : this.focusadmission.adms_lvl,
            "stud_id" : this.focusadmission.stud_id
      };
      const emailObject = {
        "stud_fname": this.focusadmission.stud_fname,
        "stud_lname": this.focusadmission.stud_lname,
        "stud_mname": this.focusadmission.stud_mname,
        "stud_suffix": this.focusadmission.stud_suffix,
        "stud_email": this.focusadmission.stud_email,
        "email_subject" : this.admissionRequestStatus.toUpperCase()
      };
      if (this.focusadmission.adms_status !== this.admissionRequestStatus) {
        event.currentTarget.textContent = "...";
        const data = await send.UpdateAdmission(admissionRequestObject);
        if (data.includes('Successfully')) {
          this.getAllAdmission();
          this.getAllAdmissionHistory();
          this.resetAdminScreens();
          this.ShowLoading = true;
          this.loadingMessage = "Successfully Updated Admission " + this.focusadmission.adms_id;
          this.loadingScreenTimeout();
          this.ShowSchoolAdmissions= true;
        }
      } else {
        this.ShowAdmissionPopup = false;
        this.ShowSchoolAdmissions = true;
      }
      this.EmailMessage(emailObject,this.admissionRequestStatus);
    },
    async checkDocumentExist() {
      const documentObject = {
        "docu_id": this.focusdoctype.docu_id,
        "docu_type": this.documentTypeRename,
        "docu_is_active": this.focusdoctype.docu_is_active
      };
      const Exists = Object.values(this.docType).some(document => document.docu_type === this.documentTypeRename);
      if (Exists) {
        this.checkDocument = true;
      } else {
        this.documentRenameButtonText = '...';
        const data = await send.UpdateDocument(documentObject);
        this.getAllDocuments();
        this.resetAdminScreens();
        this.ShowLoading = true;
        this.loadingMessage = data + ": " + this.focusdoctype.docu_type;
        this.loadingScreenTimeout();
        this.ShowDocumentTypes = true;
      }
        this.documentRenameButtonText = 'Save changes';
    },
    async removeDocument() {
      const documentObject = {
        "confirm_password": this.confirmPassword,
        "admin_password": this.adminDetails.admin_password,
        "docu_id": this.focusdoctype.docu_id,
        "docu_type": this.focusdoctype.docu_type,
        "docu_is_active": "false"
        };
      const data = await send.RemoveDocument(documentObject);
      if (data.includes('Successfully')) {
        this.getAllDocuments();
        this.resetAdminScreens();
        this.checkDocument = false;
        this.ShowDocType = false;
        this.ShowLoading = true;
        this.loadingMessage = data + ": " + this.focusdoctype.docu_type;
        this.loadingScreenTimeout();
        this.ShowDocumentTypes = true;
      } else {
        this.confirmPasswordIncorrect = true;
        this.confirmPasswordMessage = "Password is incorrect.";
      }
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
      this.adminCreateMessage = '';
      this.checkUsername = false;
      this.fieldValidation = false;
      const exists = Object.values(this.adminslist).some(
      admin => admin.admin_username === this.createAdminUsername);
      if (!(this.createAdminFirstname && this.createAdminLastname && this.createAdminPassword && this.createAdminUsername)) {
        this.fieldValidation = true;
        this.adminCreateMessage = 'The field is required';
        return;
      }
      if (exists) {
        this.checkUsername = true;
        this.adminCreateMessage = 'The username is already exist!';
      } else {
        this.ShowAdminCreatePopup = false;
        this.ShowPasswordConfirm = true;
      }
    },
    checkUsernameAvailability() {
      const exists = Object.values(this.adminslist).some(
      admin => admin.admin_username === this.newAdminUsername);
      if (exists) {
        return true;
      } else {
        return false;
      }
    },
    loadingScreenTimeout() {
      setTimeout(() => {
        this.ShowAdminBoot = false;
        this.ShowLoading = false;
        this.createAdminUsername = '';
        this.createAdminPassword = '';
        this.createAdminFirstname = '';
        this.createAdminLastname = '';
        this.documentType = '';
        this.documentTypeRename = '';
        this.confirmPassword = '';
        this.Process = '';
      },2000);
    },
    async documentCreate() {
      this.documentMessage = '';
      const documentObject = {
        "docu_type" : this.documentType
      }
      this.documentExist = false;
      const exists = Object.values(this.docType).some(
        document => document.docu_type === this.documentType);
      if (!this.documentType) {
        this.documentExist = true;
        this.documentMessage = "The field is required";
        return;
      }
      if (exists) {
        this.documentExist = true;
        this.documentMessage = "That document type already exists.";
      } else {
        const data = await send.documentCreate(documentObject);
        this.getAllDocuments();
        this.resetAdminScreens();
        this.ShowLoading = true;
        this.loadingMessage = data + ": " + this.documentType;
        this.loadingScreenTimeout();
        this.ShowDocumentTypes = true;
      }
    },
    async PasswordConfirmation() {
      console.log(this.Process);
      console.log(this.confirmPassword);
      this.confirmPasswordIncorrect = false;
      this.confirmPasswordMessage = '';
      if (this.confirmPassword) {
        this.passwordConfirmButtonText = '...';
        switch (this.Process) {
          case 'Change Username':
            const adminObject = {
            "admin_id": this.focusadmin.admin_id,
            "admin_fname": this.focusadmin.admin_fname,
            "admin_lname": this.focusadmin.admin_lname,
            "admin_username": this.newAdminUsername,
            "admin_password": this.focusadmin.admin_password,
            "admin_is_active": this.focusadmin.admin_is_active,
            "admin_old_password": this.focusadmin.admin_password,
            "confirm_password": this.confirmPassword
          };
          const data = await send.UpdateAdminDetails(adminObject);
          if (data.includes('Successfully')) {
            this.getAllAdmin();
            this.resetAdminScreens();
            this.ShowLoading = true;
            this.loadingMessage = data + ": " + this.newAdminUsername;
            this.loadingScreenTimeout();
            this.ShowAdministrators = true;
          } else {
            this.confirmPasswordIncorrect = true;
            this.confirmPasswordMessage = "Password is incorrect.";
          }
            break;
          case 'Change Password':
            const adminObjectPassword = {
            "admin_id": this.focusadmin.admin_id,
            "admin_fname": this.focusadmin.admin_fname,
            "admin_lname": this.focusadmin.admin_lname,
            "admin_username": this.focusadmin.admin_username,
            "admin_is_active": this.focusadmin.admin_is_active,
            "admin_password": this.newAdminPassword,
            "admin_old_password": this.focusadmin.admin_password,
            "confirm_password": this.confirmPassword
            };
            const data_password = await send.UpdateAdminDetails(adminObjectPassword);
            if (data_password.includes('Successfully')) {
            this.getAllAdmin();
            this.getAdminById();
            this.resetAdminScreens();
            this.ShowLoading = true;
            this.loadingMessage = data_password + ": " + this.newAdminUsername;
            this.loadingScreenTimeout();
            this.ShowAdministrators = true;
            }else {
              this.confirmPasswordIncorrect = true;
              this.confirmPasswordMessage = "Password is incorrect.";
            }
            break;
          case 'Remove':
            const adminObjectRemove = {
              "admin_id": this.focusadmin.admin_id,
              "admin_fname": this.focusadmin.admin_fname,
              "admin_lname": this.focusadmin.admin_lname,
              "admin_username": this.focusadmin.admin_username,
              "admin_is_active": "false",
              "admin_password": this.focusadmin.admin_password,
              "admin_old_password": this.adminDetails.admin_password,
              "confirm_password": this.confirmPassword
            };
            const data_remove = await send.UpdateAdminDetails(adminObjectRemove);
            if (data_remove.includes('Successfully')) {
              this.getAllAdmin();
              this.resetAdminScreens();
              this.ShowLoading = true;
              this.loadingMessage = "Successfully deleted " + this.focusadmin.admin_username;
              this.loadingScreenTimeout();
              this.ShowAdministrators = true;
            } else {
              this.confirmPasswordIncorrect = true;
              this.confirmPasswordMessage = "Password is incorrect.";
          }
            break;
          case 'Delete Document':
            this.removeDocument();
            break;
          case 'Toggle Admissions':
            let control = this.controls.find(control => control.ctrl_key === "toggle_admissions");
            const controlObject = {
              "ctrl_key": "toggle_admissions",
              "ctrl_value": String(!control.ctrl_value),
            };
            const data_toggle = await send.UpdateAdminControls(controlObject);
            if (data_toggle.includes('Successfully')) {
              this.ShowPasswordConfirm = false;
              this.ShowLoading = true;
              control.ctrl_value = !control.ctrl_value;
              this.loadingMessage = `Successfully ${control.ctrl_value ? 'opened' : 'closed'} admissions`;
              this.loadingScreenTimeout();
            } else {
              this.confirmPasswordIncorrect = true;
              this.confirmPasswordMessage = "Password is incorrect.";
            }
            break;
          default:
            const adminObjectCreate = {
              "admin_fname": this.createAdminFirstname,
              "admin_lname": this.createAdminLastname,
              "admin_username": this.createAdminUsername,
              "admin_password": this.createAdminPassword,
              "admin_old_password": this.adminDetails.admin_password,
              "confirm_password": this.confirmPassword,
            };
            const data_create = await send.CreateAdmin(adminObjectCreate);
            if (data_create.includes('Successfully')) {
              this.getAllAdmin();
              this.resetAdminScreens();
              this.ShowLoading = true;
              this.loadingMessage = data_create + ": " + this.createAdminUsername;
              this.loadingScreenTimeout();
              this.ShowAdministrators = true;
            } else {
              this.confirmPasswordIncorrect = true;
              this.confirmPasswordMessage = data_create;
            }
            break;
        }
      } else {
        this.confirmPasswordIncorrect = true;
        this.confirmPasswordMessage = "Field is empty!";
      }
      this.passwordConfirmButtonText = 'Verify';
    },
    async submitTrackID(event) {
      this.requestTrackMessage = '';
      this.submitted = true;
      if (this.trackID) {
        this.resetScreens();
        this.ShowRequestDetails = true;
        event.currentTarget.textContent = "...";
        const response = await fetch.getRequestById(this.trackID);
        this.requestTrack = response.data;
        if (!this.requestTrack) {
          this.errorStatus = true;
        }
      }
    },
    Logout() {
      this.resetAdminScreens();
      this.resetScreens();
      this.ShowUserMenu = true;
      clearInterval(this.interval = false);
    },
    async getAllAdmission(){
      const data = await fetch.getAllAdmission();
      this.activeadmissionslist = data.data;
    },
    async getAllAdmissionHistory(){
      const data = await fetch.getAllAdmissionHistoryWithYear();
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
    async getAllDocuments() {
      const data = await fetch.getAllDocuments();
      this.docType = data.filter(document => document.docu_is_active === true);
    },
    async getAllStudent() {
      const data = await fetch.getAllStudent();
      this.fullstudentslist = data.data;
    },
    async getAllAdmin() {
      const data = await fetch.getAllAdmin();
      this.adminslist = data.data.filter(admin => admin.admin_is_active);
    },
    async getAllAuditLogAdmission() {
      const data = await fetch.getAllAuditLogAdmission();
      this.admissionauditslist = data.data;
    },
    async getAllAuditLogRequest() {
      const data = await fetch.getAllAuditLogRequest();
      this.requestauditslist = data.data;
    },
    async getAdminControls() {
      const data = await fetch.getAdminControls();
      this.controls = data.data;
    },
    async checkLogin() {
      this.verified = true;
      this.submitted = true;
      this.login = true;
      this.loginButtonText = '...';
      if (this.username && this.password) {
        const loginObject = {
          username: this.username,
          password: this.password
        };
        let data = await send.AdminLogin(loginObject);
        if (data.data) {
          this.ShowAdminLogin = false;
          this.ShowAdminSplash = true;

          this.adminBootMessage = "Fetching admin controls...";
          await this.getAdminControls();

          this.adminBootMessage = "Fetching document requests...";
          await this.getAllRequest();
          await this.getAllRequestHistory();

          this.adminBootMessage = "Fetching admission forms...";
          await this.getAllAdmission();
          await this.getAllAdmissionHistory();

          this.adminBootMessage = "Fetching student users...";
          await this.getAllStudent();

          this.adminBootMessage = "Fetching administrators...";
          await this.getAllAdmin();

          this.adminBootMessage = "Fetching audit logs...";
          await this.getAllAuditLogAdmission();
          await this.getAllAuditLogRequest();

          this.loginMessage = data.message;
          this.adminDetails = data.data;
          this.verified = true;
          this.AdminID = data.data.admin_id;
          this.resetScreens();
          this.intervalUpdate();

          this.ShowAdminSplash = false;
          this.ShowAdminBoot = true;
          this.loadingScreenTimeout();

          this.ShowAdminPanel = true;
          this.ShowDocumentRequests = true;
        } else {
          this.verified = false;
          this.login = false;
          this.loginMessage = "Invalid Credentials. Access denied!";
        }
      } else {
        this.verified = false;
        this.loginMessage = "Please enter username or password!";
      }
      this.loginButtonText = 'Login';
    },

    async submitRequest(event) {
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
        event.currentTarget.textContent = "...";
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
    async validateAdmissionForm(event) {
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
        event.currentTarget.textContent = "...";
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
    snapRequestSearch() {
      this.requestsearch = this.requestsearchlive;
    },
    snapAdmissionSearch() {
      this.admissionsearch = this.admissionsearchlive;
    },
    snapStudentSearch() {
      this.studentsearch = this.studentsearchlive;
    },
  },
  computed: {
    requestslist() {
      let final = [];
      if (this.requestview === 'active') {
        final = [...this.activerequestslist];
      } else if (this.requestview === 'archived') {
        final = [...this.archivedrequestslist];
      }

      if (this.requestsearch) {
        const q = this.requestsearch.toString().toLowerCase();
        final = final.filter(item =>
            item.req_track_id.toString().toLowerCase().startsWith(q)
        );
      }

      final = final.sort((a, b) => {
        const valA = a[this.requestsort]?.toUpperCase();
        const valB = b[this.requestsort]?.toUpperCase();

        if (valA < valB) return this.requestorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.requestorder === 'asc' ? 1 : -1;
        return 0;
      });

      const filters = [];
      if (this.requestview === 'active' && this.requestshowpending) filters.push(req => (req.req_status ?? req.reqhs_status)?.toUpperCase() === 'PENDING');
      if (this.requestview === 'active' && this.requestshowready) filters.push(req => (req.req_status ?? req.reqhs_status)?.toUpperCase() === 'READY');
      if (this.requestview === 'archived' && this.requestshowrejected) filters.push(req => (req.req_status ?? req.reqhs_status)?.toUpperCase() === 'REJECTED');
      if (this.requestview === 'archived' && this.requestshowretrieved) filters.push(req => (req.req_status ?? req.reqhs_status)?.toUpperCase() === 'RETRIEVED');

      return final.filter(item =>
          filters.some(fn => fn(item)) // item passes if it matches ANY active filter
      );
    },
    admissionslist() {
      let final = [];
      if (this.admissionview === 'current') {
        final = [...this.activeadmissionslist];
      } else {
        console.table(this.archivedadmissionslist[this.admissionview] || []);
        final = [...(this.archivedadmissionslist[this.admissionview])];
      }

      if (this.admissionsearch) {
        const q = this.admissionsearch.toString().toLowerCase();
        final = final.filter(item =>
            ([item.stud_fname, item.stud_mname, item.stud_lname, item.stud_suffix].filter(Boolean).join(' '))
                .toLowerCase().includes(q)
        );
      }

      final = final.sort((a, b) => {
        const valA = a[this.admissionsort]?.toUpperCase();
        const valB = b[this.admissionsort]?.toUpperCase();

        if (valA < valB) return this.admissionorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.admissionorder === 'asc' ? 1 : -1;
        return 0;
      });

      const filters = [];
      if (this.admissionshowpending) filters.push(adm => (adm.adms_status ?? adm.admhs_status)?.toUpperCase() === 'PENDING');
      if (this.admissionshowrejected) filters.push(adm => (adm.adms_status ?? adm.admhs_status)?.toUpperCase() === 'REJECTED');
      if (this.admissionshowwaitlisted) filters.push(adm => (adm.adms_status ?? adm.admhs_status)?.toUpperCase() === 'WAITLISTED');
      if (this.admissionshowaccepted) filters.push(adm => (adm.adms_status ?? adm.admhs_status)?.toUpperCase() === 'ACCEPTED');

      return final.filter(item =>
          filters.some(fn => fn(item)) // item passes if it matches ANY active filter
      );
    },
    studentslist() {
      let final = [...this.fullstudentslist];

      if (this.studentsearch) {
        const q = this.studentsearch.toString().toLowerCase();
        final = final.filter(item =>
            ([item.stud_fname, item.stud_mname, item.stud_lname, item.stud_suffix].filter(Boolean).join(' '))
                .toLowerCase().includes(q)
        );
      }

      return final.sort((a, b) => {
        const valA = a[this.studentsort];
        const valB = b[this.studentsort];

        if (valA < valB) return this.studentorder === 'asc' ? -1 : 1;
        if (valA > valB) return this.studentorder === 'asc' ? 1 : -1;
        return 0;
      });
    },
    auditslist() {

      const requestCopies = this.requestauditslist.map(item =>
        ({ ...item })
      );
      const admissionCopies = this.admissionauditslist.map(item =>
        ({ ...item })
      );

      const requestTagged = requestCopies.map(item => ({
        ...item,
        chg_type: "Document Request"
      }));
      const admissionTagged = admissionCopies.map(item => ({
        ...item,
        chg_type: "School Admission"
      }));

      let final = [...requestTagged, ...admissionTagged];

      if (this.ShowAuditLogByAdmin) {
        final = final.filter(aud => aud.admin_id === this.focusadmin.admin_id);
      }

      if (this.auditfilterdate) {
        const start = new Date(this.auditfilterdate);
        final = final.filter(aud => {
          const changed = new Date(aud.chg_datetime);
          return changed >= start;
        });
      }

      const filters = [];
      if (this.auditshowrequest) filters.push(aud => aud.chg_type.toUpperCase() === 'DOCUMENT REQUEST');
      if (this.auditshowadmission) filters.push(aud => aud.chg_type.toUpperCase() === 'SCHOOL ADMISSION');

      return final.filter(item =>
          filters.some(fn => fn(item)) // item passes if it matches ANY active filter
      );
    },
  },
  watch: {
    requestview(newVal) {
      if (newVal === 'active') {
        this.requestshowpending = true;
        this.requestshowready = true;
        this.showactiverequestfilters = true;
      } else {
        this.requestshowrejected = true;
        this.requestshowretrieved = true;
        this.showactiverequestfilters = false;
      }
    }
  }
}).mount('#app');
