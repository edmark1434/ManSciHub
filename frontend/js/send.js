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