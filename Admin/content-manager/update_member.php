<link rel="stylesheet" href="content-manager/css/update_member.css">
<link rel="stylesheet" href="css/update_member.css">

<div id="content" class="dashboard">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" href="../Admin.css" />
    <script>
        function imageData(url) {
            const originalUrl = url || '';
            return {
                previewPhoto: originalUrl,
                fileName: null,
                emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
                updatePreview($refs) {
                    var reader,
                        files = $refs.input.files;
                    reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewPhoto = e.target.result;
                        this.fileName = files[0].name;
                    };
                    reader.readAsDataURL(files[0]);
                },
                clearPreview($refs) {
                    $refs.input.value = null;
                    this.previewPhoto = originalUrl;
                    this.fileName = false;
                }
            };
        }
    </script>
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Update Choir Member Profile</h3>

    <div class="main-cont ">
        <div class="add-main-cont">
            <div class="add-member add-cont">
                <div class="file-input input-layout">
                    <section class="container max-w-xl mx-auto flex flex-col py-8">




                        <div class="py-8">

                            <!-- If you wish to reference an existing file (i.e. from your database), pass the url into imageData() -->
                            <div x-data="imageData()" class="file-input flex items-center">

                                <!-- Preview Image -->
                                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <!-- Placeholder image -->
                                    <div x-show="!previewPhoto">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <!-- Show a preview of the photo -->
                                    <div x-show="previewPhoto" class="h-12 w-12 rounded-full overflow-hidden">
                                        <img :src="previewPhoto"
                                            alt=""
                                            class="h-12 w-12 object-cover">
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <!-- File Input -->
                                    <div class="ml-5 rounded-md shadow-sm">
                                        <!-- Replace the file input styles with our own via the label -->
                                        <input @change="updatePreview($refs)" x-ref="input"
                                            type="file"
                                            accept="image/*,capture=camera"
                                            name="photo" id="photo"
                                            class="custom">
                                        <label for="photo"
                                            class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-300 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50 active:text-indigo-800 transition duration-150 ease-in-out">
                                            Upload Photo
                                        </label>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mx-2">
                                        <!-- Display the file name when available -->
                                        <span x-text="fileName || emptyText"></span>
                                        <!-- Removes the selected file -->
                                        <button x-show="fileName"
                                            @click="clearPreview($refs)"
                                            type="button"
                                            aria-label="Remove image"
                                            class="mx-1 mt-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </section>
                </div>
                <div class="input-cont">
                    <h3 class="input-title-update">Edit Member Information:</h3>
                    <div class="name-cont">
                        <div class="edit-layout">
                            <h4>Name: Dominic</h4>

                        </div>

                        <input class="input-name-add" id="input-name" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="name-cont">
                        <div class="edit-layout">
                            <h4>Link: https://www.facebook.com/xrnozy</h4>

                        </div>

                        <input class="input-name-add" id="input-link" type="text" name="fbLink" placeholder="Facebook Link">
                    </div>
                    <div class="name-cont">
                        <div class="edit-layout">
                            <h4>Category: Alto</h4>

                        </div>

                        <input class="input-name-add" id="input-category" type="text" name="Category" placeholder="Category">
                    </div>

                    <div class="buttons-add">
                        <button class="add-member-btn">Update</button>
                        <button class="cancel-member-btn">Cancel</button>
                    </div>

                </div>


            </div>

        </div>


    </div>

</div>