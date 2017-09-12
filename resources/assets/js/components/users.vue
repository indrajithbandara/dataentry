<template>
    <div>
        <!-- User Table -->
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Raquel Gonzales</td>
                        <td>rgonzales@ksentusa.com</td>
                        <td>1</td>
                        <td><button class="btn btn-warning">Edit</button></td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Helen Vargus</td>
                        <td>admin@ksentusa.com</td>
                        <td>2</td>
                        <td><button class="btn btn-warning">Edit</button></td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Simon Gonzales</td>
                        <td>sgonzales@ksentusa.com</td>
                        <td>3</td>
                        <td><button class="btn btn-warning">Edit</button></td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Carl Kessler</td>
                        <td>ckessler@ksentusa.com</td>
                        <td>4</td>
                        <td><button class="btn btn-warning">Edit</button></td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>General Employee</td>
                        <td>admin@ksentusa.com</td>
                        <td>5</td>
                        <td><button class="btn btn-warning">Edit</button></td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end of users table -->
        <hr>
        <!-- Add User Form -->
        <div>
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Permissions</label>
                    <select class="form-control">
                        <option>Choose an option</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>
        </div>
        <!-- End of add user form -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                // key: value pairs
            }
        },
        methods: {

        }
    }
</script>