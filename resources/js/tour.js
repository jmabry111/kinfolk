import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

window.startKinfolkTour = function () {
    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            classes: 'kinfolk-tour',
            scrollTo: { behavior: 'smooth', block: 'center' },
            cancelIcon: { enabled: true },
        },
    });

    tour.addStep({
        id: 'welcome',
        text: `<strong>Welcome to Kinfolk! 🎉</strong><br><br>
               Let's take a quick tour so you know your way around.
               This will only take a minute!`,
        buttons: [
            { text: 'Skip Tour', action: () => tour.cancel(), classes: 'shepherd-button-secondary' },
            { text: "Let's Go!", action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'dashboard',
        text: `<strong>Your Dashboard</strong><br><br>
               This is where you'll see upcoming birthdays and holidays,
               organized by how soon they are.`,
        attachTo: { element: '.dashboard-upcoming', on: 'bottom' },
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Next', action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'groups',
        text: `<strong>My Groups</strong><br><br>
               Start by creating a Family Group — this is how you organize
               your contacts. You can have multiple groups, like "Family" and "Work Friends".`,
        attachTo: { element: 'a[href*="family-groups"]', on: 'bottom' },
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Next', action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'contacts',
        text: `<strong>Add Contacts</strong><br><br>
               Once you have a group, add the people whose birthdays
               you want to track. You can classify them as <strong>Kin</strong> (family)
               or <strong>Folk</strong> (friends & others).`,
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Next', action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'gifts',
        text: `<strong>Gift Ideas</strong><br><br>
               On each contact's page you can add gift ideas. Mark them
               <strong>public</strong> so group members can coordinate,
               or keep them <strong>private</strong> just for yourself.`,
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Next', action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'invites',
        text: `<strong>Invite Others</strong><br><br>
               You can invite family and friends to join your group.
               They'll get a link to create their account and join automatically.`,
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Next', action: () => tour.next() },
        ],
    });

    tour.addStep({
        id: 'finish',
        text: `<strong>You're all set! 🎊</strong><br><br>
               You can replay this tour anytime from your
               <strong>Profile Settings</strong> page.`,
        attachTo: { element: '.user-dropdown-trigger', on: 'bottom' },
        buttons: [
            { text: 'Back', action: () => tour.back(), classes: 'shepherd-button-secondary' },
            { text: 'Finish!', action: () => tour.complete() },
        ],
    });

    tour.on('complete', () => markWalkthroughComplete());
    tour.on('cancel', () => markWalkthroughComplete());

    tour.start();
};

function markWalkthroughComplete() {
    fetch('/walkthrough/complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    });
}
