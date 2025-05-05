export async function getAllDocuments() {
    const response = await fetch("http://localhost:8000/api/Document");
    let data = {};
    if (response.ok) {
        data = await response.json();
    } else {
        console.error('Request failed with status:', response.status);
    }
    return data;
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
export async function getAllAuditLogAdmission() {
    const response = await fetch(`http://localhost:8000/api/AuditLog-Admission`);
    const data = await response.json();
    if (response.ok) {
        return data;
    } else {
        return data.message;
    }
}
export async function getAllAuditLogRequest() {
    const response = await fetch(`http://localhost:8000/api/AuditLog-Request`);
    const data = await response.json();
    if (response.ok) {
        return data;
    } else {
        return data.message;
    }
}

export async function getAdminControls() {
    const response = await fetch(`http://localhost:8000/api/AdminControls`);
    const data = await response.json();
    if (response.ok) {
        return data;
    } else {
        return data.message;
    }
}

export async function getRequestById(data) {
    const response = await fetch(`http://localhost:8000/api/Request/${data}`);
    return await response.json();
}

export async function getRequestForms() {
  const url =`https://docs.google.com/spreadsheets/d/e/2PACX-1vQxrIYs_3JtRBdOmzuTe-HJCF0R7Jk9xv2yYPClGfymzOCrTjRTunCOg61QJ_jWTK3xNFg9BYXbRbiQ/pub?output=csv&gid=1449741920&&cachebust=${Date.now()}`;

  const res = await fetch(url);
  if (!res.ok) throw new Error(`Fetch failed: ${res.statusText}`);
  const csvText = await res.text();

  // Split into lines, then cells
  const rows = csvText.trim().split(/\r?\n/).map(line => line.split(","));
  const [header, ...body] = rows;

  // Turn into array of objects
  const data = body.map(row =>
    Object.fromEntries(header.map((key, i) => [key, row[i]]))
  );
    console.log(data);
  return data;   // ← now this async function truly returns the array
}
