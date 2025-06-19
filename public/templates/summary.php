<div class="summary-wrap">
<h2>Travel Information</h2>
    <input type="hidden" id="summary_object" data-obj="">
    <table id="dataTable">
        <thead>
            <tr>
                <th>Category</th>
                <th>Description</th>
                <th>Adult Cost</th>
                <th>Children Cost</th>
                <th>Infant Cost</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button class="request_package">Request Package</button>

    <!-- Hidden Panel -->
    <div id="packagePanel" class="hidden">
        <h3>Request a Package</h3>
        <div id="packageForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Submit Package</button>
        </div>
    </div>

</div>