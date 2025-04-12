export async function DocumentRequest(data) {
    const response = await fetch("http://localhost:8000/api/Service/DocumentRequest", {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    });

    const response_data = await response.json();
    return response_data;
}

export async function AdmissionRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/AdmissionRequest", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    response_data = await response.json();
    return response_data;
}

export async function getStudentByFilter(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Student/Filter", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    return response_data;
}
export async function TransferRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/TransferRequest", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function AdminLogin(data) {
    const response = await fetch("http://localhost:8000/api/Admin/login", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    let response_data = {};
    const text = await response.text();
    if (!text) {
        return { message: "Error" };
    }
    else {
        response_data = JSON.parse(text);
    }
    return response_data;
    }
export async function CreateLogin(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admin", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateAdmission(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admission/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Request/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateLogin(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admin/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function DeleteLogin(data) {
    const response = await fetch(`http://localhost:8000/api/Admin/Delete/${data}`, {
        method: 'DELETE',
        headers: {
            "Content-Type": "application/json"
        }});
    let response_data = {};
    response_data = await response.json();
        if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
