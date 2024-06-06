<form hx-post="/submit_bug.php" hx-trigger="submit" hx-target="#bug-report-form" class="p-4 bg-white shadow-md rounded">
    <label class="block mb-2">
        Title:
        <input type="text" name="title" class="border p-2 w-full" required>
    </label>
    <label class="block mb-2">
        Comment:
        <textarea name="comment" class="border p-2 w-full" required></textarea>
    </label>
    <label class="block mb-2">
        Urgency:
        <select name="urgency" class="border p-2 w-full" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </label>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Submit Bug</button>
</form>
