<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

use Illuminate\Support\Facades\URL;


use App\Observers\GlobalObserver;
use App\Models\Admin;
use App\Models\AdminActivityLog;
use App\Models\Classroom;
use App\Models\Competence;
use App\Models\CsFile;
use App\Models\CsLog;
use App\Models\CsMessage;
use App\Models\CsRoom;
use App\Models\Exercise;
use App\Models\ExerciseItem;
use App\Models\ExerciseModel;
use App\Models\ExercisePoint;
use App\Models\ExerciseType;
use App\Models\Help;
use App\Models\Lesson;
use App\Models\LessonItem;
use App\Models\Mapel;
use App\Models\Medium;
use App\Models\ModelHasPermission;
use App\Models\ModelHasRole;
use App\Models\OnlineMeeting;
use App\Models\Permission;
use App\Models\Post;
use App\Models\PostChildComment;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\QuestionCategory;
use App\Models\Report;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\Serial;
use App\Models\SerialLog;
use App\Models\ShareExercise;
use App\Models\Student;
use App\Models\Subtheme;
use App\Models\Task;
use App\Models\Theme;
use App\Models\UnansweredQuestion;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Daftarkan Firebase Database sebagai singleton
        $this->app->singleton(Database::class, function () {
            $factory = (new Factory)
                ->withServiceAccount(config('firebase.credentials'))
                ->withDatabaseUri(config('firebase.database_url'));

            return $factory->createDatabase();
        });
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        // Force HTTPS di production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        date_default_timezone_set(config('app.timezone'));
        \Carbon\Carbon::setDefaultTimezone(config('app.timezone'));


        Admin::observe(GlobalObserver::class);
        AdminActivityLog::observe(GlobalObserver::class);
        Classroom::observe(GlobalObserver::class);
        Competence::observe(GlobalObserver::class);
        CsFile::observe(GlobalObserver::class);
        CsLog::observe(GlobalObserver::class);
        CsMessage::observe(GlobalObserver::class);
        CsRoom::observe(GlobalObserver::class);
        Exercise::observe(GlobalObserver::class);
        ExerciseItem::observe(GlobalObserver::class);
        ExerciseModel::observe(GlobalObserver::class);
        ExercisePoint::observe(GlobalObserver::class);
        ExerciseType::observe(GlobalObserver::class);
        Help::observe(GlobalObserver::class);
        Lesson::observe(GlobalObserver::class);
        LessonItem::observe(GlobalObserver::class);
        Mapel::observe(GlobalObserver::class);
        Medium::observe(GlobalObserver::class);
        ModelHasPermission::observe(GlobalObserver::class);
        ModelHasRole::observe(GlobalObserver::class);
        OnlineMeeting::observe(GlobalObserver::class);
        Permission::observe(GlobalObserver::class);
        Post::observe(GlobalObserver::class);
        PostChildComment::observe(GlobalObserver::class);
        PostComment::observe(GlobalObserver::class);
        Product::observe(GlobalObserver::class);
        QuestionCategory::observe(GlobalObserver::class);
        Report::observe(GlobalObserver::class);
        Role::observe(GlobalObserver::class);
        RoleHasPermission::observe(GlobalObserver::class);
        Serial::observe(GlobalObserver::class);
        SerialLog::observe(GlobalObserver::class);
        ShareExercise::observe(GlobalObserver::class);
        Student::observe(GlobalObserver::class);
        Subtheme::observe(GlobalObserver::class);
        Task::observe(GlobalObserver::class);
        Theme::observe(GlobalObserver::class);
        UnansweredQuestion::observe(GlobalObserver::class);
        User::observe(GlobalObserver::class);
    }
}
