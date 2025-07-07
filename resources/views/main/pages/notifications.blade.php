@extends('main.master-main')

@section('main')

<div class="section section--home section--scroll">
    <div class="section__header">
        <button type="button" class="section__back trigger-back"><i class="ri ri-arrow-left-line"></i></button>
        <p class="section__category-title">Notifications</p>
    </div>
    <x-navbar-top>Notifications</x-navbar-top>

    {{-- Affichage des notifications --}}
    <div class="notification__body">
        @if ($notifications->count() > 0)
            <div class="notification__content-item">
            @foreach ($notifications as $notification)
                <div class="notification__item {{ is_null($notification->read_at) ? 'notification__item--unread' : '' }}">
                    {{-- Icône de la notification --}}
                    <div class="notification__icon">
                        <img
                            src="{{ $notification->data['user_avatar'] ? asset($notification->data['user_avatar']) : asset('images/default-avatar.png') }}"
                            alt="Avatar de {{ $notification->data['user_name'] ?? 'Utilisateur' }}"
                            class="notification__avatar"
                        >
                    </div>

                    {{-- Contenu principal --}}
                    <div class="notification__content">
                        <p class="notification__message">{{ $notification->data['message'] ?? 'Notification' }}</p>
                        <span class="notification__time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="notification__actions">
                        {{-- Bouton "Marquer comme lu" si non lu --}}
                        @if (is_null($notification->read_at))
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="notification__mark-read-form">
                                @csrf
                                <button type="submit" class="notification__mark-read-btn" title="Marquer comme lu">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Bouton supprimer --}}
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="notification__delete-form" onsubmit="return confirm('Supprimer cette notification ?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="notification__delete-btn" title="Supprimer la notification">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            </div>
        @else
            <p class="notification__empty">Aucune notification pour le moment.</p>
        @endif
    </div>


</div>

@endsection
@section('sidebar')
    <div class="sidebar__content">
        @include('partials.sidebarContent')
    </div>
@endsection
