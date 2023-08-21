<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
    >
        <template #field>
            <form
                name="files"
                action="/nova-api/custom/aws-upload-dropzone"
                method="POST"
                class="dropzone"
                id="my-dropzone"
                enctype="multipart/form-data"
            >
                <input type="hidden" v-model="value" />
            </form>
            <div class="flex flex-wrap gap-2 mt-3" v-if="field.value">
                <div class="mt-2 mr-3" v-for="ob in data">
                    <a :href="ob.url">
                        <img
                            :src="ob.iconURL"
                            :key="ob.ext"
                            id=""
                            width="100"
                            height="100"
                        />
                    </a>
                    <div class="mt-2 text-center">
                        <a
                            class="dropzone_remove"
                            @click="removeFile(ob.name)"
                            href="javascript:void(0)"
                            >Remove</a
                        >
                    </div>
                </div>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import Dropzone from "dropzone";

export default {
    mixins: [FormField, HandlesValidationErrors],
    props: ["resourceName", "resourceId", "field"],
    data() {
        return {
            dropzone: null,
            files: [],
            aws: {
                filesURL: null,
            },
            data: [],
            imgExt: [
                "jfif",
                "jpg",
                "jpeg",
                "png",
                "gif",
                "tiff",
                "png",
                "webp",
                "bmp",
            ],
            acceptedFiles:
                "image/jpeg,image/png,image/gif,image/jpg,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            acceptedMimeTypes:
                "image/jpeg,image/png,image/gif,image/jpg,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            pdfExt: ["pdf"],
            docExt: ["doc", "docm", "docx"],
        };
    },
    // watch: {
    //     files: function (n, o) {
    //         console.log("new value", n);
    //     },
    // },
    mounted() {
        let vm = this;
        // load added data
        if (vm.field.value) {
            let URLS = JSON.parse(vm.field.value);
            if (URLS !== null) {
                URLS.forEach((f) => {
                    vm.files.push(f); //append existing files to array

                    let ext = vm.getFilenameFromUrl(f).split(".")[1];
                    let iconURL = "";
                    if (vm.imgExt.includes(ext.toLowerCase())) {
                        iconURL = f;
                    } else if (vm.pdfExt.includes(ext.toLowerCase())) {
                        iconURL =
                            "https://cdn-icons-png.flaticon.com/512/337/337946.png";
                    } else if (vm.docExt.includes(ext.toLowerCase())) {
                        iconURL =
                            "https://cdn-icons-png.flaticon.com/512/281/281760.png";
                    }
                    vm.data.push({
                        name: vm.getFilenameFromUrl(f),
                        ext: ext,
                        url: f,
                        iconURL: iconURL,
                    });
                });
            }
        }

        // save dropzone files into aws
        this.dropzone = new Dropzone("#my-dropzone", {
            url: "/nova-api/custom/aws-upload-dropzone",
            method: "POST",
            paramName: "files", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            parallelUploads: 100,
            acceptFiles: vm.acceptedFiles,
            acceptedMimeTypes: vm.acceptedMimeTypes,
            uploadMultiple: false,
            addRemoveLinks: true,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            clickable: true,
            // accept: function (file, done) {
            //     done();
            // },
        });
        this.dropzone.on("error", function (file, errorMessage, xhr) {
            // console.log('error',file, errorMessage, xhr);
            Nova.error(errorMessage);
        });

        this.dropzone.on("success", function (file, response, xhr) {
            if (response.success) {
                let files_url = response.files_url;

                let fileNames = response.file_names;

                // console.log(fileNames[file.name])
                vm.aws.filesURL = files_url;

                // vm.aws.filesNameURL = response.files_names_url;
                // vm.files=[];
                vm.dropzone.getAcceptedFiles().forEach((f) => {
                    if (f.status === "success") {
                        let url = JSON.parse(f.xhr.response).files_url;
                        if (!vm.files.includes(url)) vm.files.push(url);
                    }
                });

                vm.value = vm.files;
                // console.log("vm.value--->", vm.value);
                // vm.aws.OriginalName = fileNames.orignal_filename;
                // vm.aws.filesName = fileNames;
                // files_url.map((value)=>{
                //   vm.value.push(value);
                // })

                Nova.success("Files added to aws.");
            } else {
                Nova.error("Files not added to aws.");
            }
            // console.log('success',response);
        });
        this.dropzone.on("removedfile", function (file) {
            // console.log("remove", file);
            // let filename = file.name;
            // let filteredValue = null;
            // let URL = vm.aws.filesNameURL[file.name];

            // // vm.aws.filesName[file.name]
            // filteredValue = vm.value.filter(function(value, index, arr){
            //     return URL !== undefined && URL !== value;
            // });
            // vm.value.map((value,key)=>{
            //     let removefileName = vm.getFilenameFromUrl(value);

            // console.log(vm.aws.filesName[file.name],removefileName,value)
            // if(vm.aws.filesName[file.name] === undefined && vm.aws.filesName[file.name] != removefileName){
            //   // filteredValue = vm.value.filter(function(value, index, arr){
            //   //     return index !== key;
            //   // });
            //   vm.value = value;
            //   // console.log('filteredValue',filteredValue)

            // }
            // });

            // vm.value = filteredValue;

            vm.files = [];
            vm.dropzone.getAcceptedFiles().forEach((f) => {
                if (
                    f.status === "success" &&
                    f.upload.uuid != file.upload.uuid
                ) {
                    let url = JSON.parse(f.xhr.response).files_url;
                    if (!vm.files.includes(url)) vm.files.push(url);
                }
            });

            if (vm.field.value) {
                let existingURLS = JSON.parse(vm.field.value);
                if (existingURLS !== null) {
                    existingURLS.forEach((f) => {
                        vm.files.push(f);
                    });
                }
            }

            vm.value = vm.files;

            if (file && file.status === "success") {
                let removeFile = JSON.parse(file.xhr.response).files_url;
                let removeFileName = vm.getFilenameFromUrl(removeFile);

                if (removeFileName !== null) {
                    let params = {
                        filename: removeFileName,
                    };

                    let res = vm.removeAwsFile(params);
                    res.then((response) => {
                        if (response.data.success) {
                            Nova.success(response.data.message);
                        } else {
                            Nova.error(response.data.message);
                        }
                    });
                } else {
                    Nova.error("File not found.");
                }
            }
        });
    },
    methods: {
        getFilenameFromUrl(url) {
            const pathname = new URL(url).pathname;
            const index = pathname.lastIndexOf("/");
            return -1 !== index ? pathname.substring(index + 1) : pathname;
        },

        async removeAwsFile(params) {
            let data = await Nova.request().post(
                "/nova-api/custom/aws-remove-dropzone",
                params
            );
            return data;
        },
        removeFile(filename) {
            if (confirm("Are you sure you want to delete.") == true) {
                let params = {
                    filename: filename,
                };
                let res = this.removeAwsFile(params);
                res.then((response) => {
                    if (response.data.success) {
                        this.data = this.data.filter((f) => f.name != filename);
                        let remainingURL = [];
                        if (this.data.length > 0) {
                            this.data.forEach((f) => {
                                remainingURL.push(f.url)
                            });
                            this.value = remainingURL
                            this.files = remainingURL
                        }

                        Nova.success(response.data.message);
                    } else {
                        Nova.error(response.data.message);
                    }
                });
            }
        },
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || "";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },
    },
};
</script>
