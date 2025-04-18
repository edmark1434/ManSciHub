export async function getAllDocuments() {
    const response = await fetch("http://localhost:8000/api/Document");
    let data = {};
    if (response.ok) {
        data = await response.json();
    } else {
        console.error('Request failed with status:', response.status);
    }
    return data.data;
}
export async function getAllRequest() {
    const response = await fetch("http://localhost:8000/api/Request");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAllAdmission() {
    const response = await fetch("http://localhost:8000/api/Admission");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAllStudent() {
    const response = await fetch("http://localhost:8000/api/Student");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAllRequestHistory() {
    const response = await fetch("http://localhost:8000/api/RequestHistory");
    const data = await response.json();
    if (response.ok) {
        return data;
    } else {
        return data.message;
    }
}
export async function getAllAdmissionHistory() {
    const response = await fetch("http://localhost:8000/api/AdmissionHistory");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAllAdmissionHistoryWithYear() {
    const response = await fetch("http://localhost:8000/api/AdmissionHistoryWithYear");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAllChangeHistory() {
    const response = await fetch("http://localhost:8000/api/ChangeHistory");
    const data = await response.json();
    return data;
}
export async function getAllAdmin() {
    const response = await fetch("http://localhost:8000/api/Admin");
    let data = {};
        if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
export async function getAdminById(id) {
    const response = await fetch(`http://localhost:8000/api/Admin/${id}`);
    const data = await response.json();
    if (response.ok) {
        return data;
    } else {
        return data.message;
    }
}

//this function is for admission close
// this will automatically transfer the all record admissions in admission_history
// and automatically update stud_enroll to false if rejected in the admission
export async function AdmissionClose() {
    const response = await fetch("http://localhost:8000/api/Service/TransferAdmission");
    let data = {};
    data = await response.json();
    if (response.ok) {
        return data.message;
    } else {
        return data.message;
    }
}
export async function getRequestById(data) {
    const response = await fetch(`http://localhost:8000/api/Request/${data}`);
    return await response.json();
}


