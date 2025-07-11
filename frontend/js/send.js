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
    const response = await fetch("http://localhost:8000/api/Service/AdmissionRequest", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    const response_data = await response.json();
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
//function for updating and removing request automatically when the status is rejected or retrieve
export async function TransferRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/TransferRequest", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
        //just change the req status to rejected or retrieve and pass the whole request details as object
        //sample data to pass
            // "req_track_id": 12345603, 
            // "req_date": "2025-04-06",
            // "req_purpose": "college admission",
            // "req_status": "REJECTED", 
            // "docu_id": 2,
            // "stud_id": 12303
    })
    response_data = await response.json();
    console.log(response_data);
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}

//this function is for admission close
// this will automatically transfer the all record admissions in admission_history
// and automatically update stud_enroll to false if rejected in the admission
export async function AdmissionClose() {
    const response = await fetch("http://localhost:8000/api/Service/TransferAdmission", {
        method: 'POST'
    })
    let data = {};
    data = await response.json();
    if (response.ok) {
        return data.message;
    } else {
        return data.message;
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
export async function CreateAdmin(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/Admin", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    //create admin
    //sample data to pass
    // "admin_username" : "joanna143467", - should be unique
    // "admin_password" : "Admin",
    // "admin_fname" : "jjy",
    // "admin_lname" : "dawdaw"
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
//create audit log
export async function CreateAuditLogRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/AuditLog-Request", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    //create admin
    //sample data to pass
    // "req_track_id" : 12345678,
    // "chg_old_val" : "pending",
    // "chg_new_val" : "retrieved",
    // "admin_id": 12017
    
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}

export async function CreateAuditLogAdmission(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/AuditLog-Admission", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    //create admin
    //sample data to pass
    // "adms_id" : 2,
    // "chg_old_val" : "pending",
    // "chg_new_val" : "retrieved",
    // "admin_id": 12017

    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
//update admission
export async function UpdateAdmission(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admission/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    //sample data to send
    //    "adms_id": "1012",
    // "adms_status" : "ACCEPTED",
    // "adms_date" : "2005-10-27",
    // "adms_lvl" : 11,
    // "stud_id" : "12330"
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}

//update request
export async function UpdateRequest(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Request/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    //whats the difference between sa kani na method and sa transfer request?
    // -and difference nila is , i condition na if ang status is gi change into retrive or reject , i call ang transferRequest na function
    // if dili rejected or retrieve just call this method

    //sample data to send
    //"req_purpose" : "college admission",
    // "docu_id" : 2,
    // "stud_id" : 12322,
    // "req_status" : "complete",
    // "req_track_id" : 12345601,
    // "req_date" : "2025-04-04"
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateAdminControls(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Service/AdminControls", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    //sample code to send
    // "ctrl_key" : "test",
    // "ctrl_value" : "i love you" , minumulto ako ng damdamin ko :( di makalayaa :(
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateAdmin(data) {
    let response_data = {};
    const response = await fetch("http://localhost:8000/api/Admin/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    //this method can be used for update whole info, password , or delete acc of admin 
    //sample data to pass
    // "admin_id":"12017",
	// "admin_fname":"joanna",
    // "admin_lname": "dawdawda",
    // "admin_username": "joanna14346789",
    // "admin_password": "Admin", 
    // "admin_is_active": "false" -- if you want to delete just set this to false
    response_data = await response.json();
    if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function UpdateAdminDetails(data) {
    const response = await fetch("http://localhost:8000/api/Service/Update/Admin", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    //this method can be used for update whole info, password , or delete acc of admin 
    //sample data to pass
    // "admin_id":"12017",
	// "admin_fname":"joanna",
    // "admin_lname": "dawdawda",
    // "admin_username": "joanna14346789",
    // "admin_password": "Admin", 
    // "admin_is_active": "false" -- if you want to delete just set this to false
    const response_data = await response.json();
    console.log(response);
    return response_data.message;
}
export async function RemoveDocument(data) {
    const response = await fetch("http://localhost:8000/api/Service/Document/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    const response_data = await response.json();
    console.log(response);
    return response_data.message;
}
export async function UpdateDocument(data) {
    const response = await fetch("http://localhost:8000/api/Document/Update", {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    })
    const response_data = await response.json();
    console.log(response);
    return response_data.message;
}
export async function DeleteAdmin(data) {
    const response = await fetch(`http://localhost:8000/api/Admin/Delete/${data}`, {
        method: 'DELETE',
        headers: {
            "Content-Type": "application/json"
        }
    });
    //if u want to delete it completely which is not recommended , just disregard this method
    let response_data = {};
    response_data = await response.json();
        if (response.ok) {
        return response_data.message;
    } else {
        return response_data.message;
    }
}
export async function documentCreate(data) {
    const response = await fetch("http://localhost:8000/api/Document", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    const response_data = await response.json();
    return response_data.message;
}
export async function emailMessage(data) {
    const response = await fetch("http://localhost:8000/api/Service/EmailNotification", {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data),
    });
    const response_data = await response.json();
    return response_data.message;
}
