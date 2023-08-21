<template>
    <!--<PanelItem :index="index" :field="field" /> -->
    <div class="flex flex-wrap gap-2">
        <div class="mt-2 mr-3" v-for="ob in data">
            <a :href="ob.url">
                <img
                    :src="ob.iconURL"
                    :key="index"
                    id=""
                    width="100"
                    height="100"
                />
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: ["index", "resource", "resourceName", "resourceId", "field"],
    data() {
        return {
            urls: null,
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
            pdfExt: ["pdf"],
            docExt: ["doc", "docm", "docx"],
        };
    },
    mounted() {
        let vm = this;
        let URLS = JSON.parse(vm.field.value);

        if (URLS !== null) {
            URLS.forEach((f) => {
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
                // vm.data.name.push(vm.getFilenameFromUrl(f))
                // vm.data.ext = vm.getFilenameFromUrl(f).split('.')[1]
                // vm.data.url = f
            });
        }

        // console.log(vm.data);
    },
    methods: {
        getFilenameFromUrl(url) {
            const pathname = new URL(url).pathname;
            const index = pathname.lastIndexOf("/");
            return -1 !== index ? pathname.substring(index + 1) : pathname;
        },
    },
};
</script>
