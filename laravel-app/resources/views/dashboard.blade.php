<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <h2 style="margin-top:20px;">Your Salary History</h2>

                    @if($calculations->count() > 0)
                    <table border="1" cellpadding="10" style="margin-top:10px;">
                    <tr>
                        <th>Job</th>
                        <th>Experience</th>
                        <th>Location</th>
                        <th>Salary</th>
                    </tr>

                    @foreach($calculations as $calc)
                    <tr>
                        <td>{{ $calc->job_title }}</td>
                        <td>{{ $calc->experience }}</td>
                        <td>{{ $calc->location }}</td>
                        <td>£{{ $calc->calculated_salary }}</td>
                    </tr>
                    @endforeach
                    </table>
                     @else
                    <p>No calculations yet.</p>
@endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
