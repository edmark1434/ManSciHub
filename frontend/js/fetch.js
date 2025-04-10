export async function getAllDocuments() {
    const response = await fetch("http://localhost:8000/api/Document");
    let data = {};
    if (response.ok) {
        data = await response.json();
        console.log(data);
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
export async function getAllRequest() {
    const response = await fetch("http://localhost:8000/api/Admission");
    let data = {};
    if (response.ok) {
        data = await response.json();
        return data;
    } else {
        return data.message;
    }
}
