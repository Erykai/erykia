function uploadImage(image, endpointUpload) {
    return new Promise((resolve, reject) => {
        // Substitua esta URL pelo endpoint do seu servidor para processar o upload da imagem
        const apiUrl = endpointUpload;
        const formData = new FormData();
        formData.append("image", image);

        $.ajax({
            url: apiUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
}