<template>
    <NavBar />
    <div class="container mx-auto">
        <div class="d-flex justify-content-center mt-8">
            <div class="w-2/3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold text-lg mb-4">Add Student</h4>

                        <form @submit.prevent="studentStore" class="form">
                            <div class="mb-3">
                                <label for="input1" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" v-model="student_data.name" id="input1"
                                    placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <label for="input2" class="form-label">Age</label>
                                <input type="text" class="form-control" name="age" v-model="student_data.age" id="input2"
                                    placeholder="Age">
                            </div>
                            <div class="mb-3">
                                <label for="input3" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" id="input3" @change="handleImageUpload">
                            </div>
                            <button type="submit" class="btn btn-warning mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h1 class="font-weight-bold text-2xl">Student List</h1>

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, index) in student_list" :key="student.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.age }}</td>
                                <td>
                                    <span v-if="student.status === 1" class="badge bg-success">Active</span>
                                    <span v-if="student.status === 0" class="badge bg-warning">Inactive</span>
                                </td>
                                <td>
                                    <div class="image-circle" v-if="student.image">
                                        <img :src="student.image" alt="Student Image" />
                                    </div>
                                </td>
                                
                                <td>
                                    <button @click.prevent="deleteStudent(student.id)" class="btn btn-danger mr-2">Delete</button>
                                    <button @click.prevent="editStudent(student.id)" class="btn btn-success mr-2">Edit</button>
                                    <button @click.prevent="changeStudentStatus(student.id)" class="btn btn-primary mr-2">Status</button>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        
<div class="modal" id="studentEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @submit.prevent="studentUpdate" class="form">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" v-model="student_update_data.name" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="age" v-model="student_update_data.age" placeholder="Age">
                    </div>
                    <div class="mb-3">
                        <label for="input4" class="form-label">Change Image</label>
                        <input type="file" class="form-control" name="image" id="input4" @change="handleUpdateImageUpload">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-dark" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary text-dark">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


    </div>
</template>

<script>
import axios from 'axios';
import NavBar from '@/Components/Main/NavBar.vue';

export default {
    data() {
        return {
            student_list: [],
            student_data: {},
            student_update_data: {},
        };
    },
    components: {
        NavBar,
    },
    beforeMount() {
        this.getStudents();
    },
    methods: {
        async getStudents() {
            const response = await axios.get(route('student.list'));
            this.student_list = response.data;
        },
        async studentStore() {
            await axios.post(route('student.store'), this.student_data);
            this.getStudents();
            this.student_data = {};
        },
        async deleteStudent(id) {
            await axios.delete(route('student.delete', id));
            this.getStudents();
        },
        async changeStudentStatus(id) {
            await axios.get(route('student.status', id));
            this.getStudents();
        },
        async editStudent(id) {
            const response = await axios.get(route('student.get', id));
            this.student_update_data = response.data;
            $('#studentEdit').modal('show');
        },
        async studentUpdate() {
            await axios.post(route('student.update', this.student_update_data.id), this.student_update_data);
            this.getStudents();
            this.student_update_data = {};
            $('#studentEdit').modal('hide');
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            this.student_data.image = URL.createObjectURL(file);
        },
        handleUpdateImageUpload(event) {
        const file = event.target.files[0];
        this.student_update_data.image = URL.createObjectURL(file);
    },
    },
};
</script>

<style>
    .image-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }

    .image-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
