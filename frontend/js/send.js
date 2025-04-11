export async function DocumentRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/DocumentRequest", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    if (response.ok) {
        response_data = await response.json();
        return response_data[0];
    } else {
        return response_data.message;
    }
}
export async function AdmissionRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/AdmissionRequest", {
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
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admin/login", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    response_data = await response.json();
    if (response.ok) {
        return response_data;
    } else {
        return response_data.message;
    }
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
export async function UpdateAdm(data) {
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
    const response = await fetch("http://localhost:8000/api/Admin/Delete/${data}", {
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
