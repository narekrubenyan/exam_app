<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="{{ route('questions.index') }}" class="nav-link">
                <i class="nav-icon far fa-question-circle"></i>
                <p>{{ __('dashboard.questions.questions') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tests.index') }}" class="nav-link">
                <i class="nav-icon far fa-calendar-check"></i>
                <p>{{ __('dashboard.tests.tests') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('students.index') }}" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>{{ __('dashboard.students.students') }}</p>
            </a>
        </li>

    </ul>
</nav>
