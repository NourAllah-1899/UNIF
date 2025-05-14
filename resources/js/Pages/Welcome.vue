<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const waveSvg = ref(null);
const mousePosition = ref({ x: 0, y: 0 });
const isHovering = ref(false);
const animatedText = ref(null);
const particles = ref([]);

onMounted(() => {
    generateWaves();
    animateText();
    createParticles();
    window.addEventListener('mousemove', trackMousePosition);
    window.addEventListener('scroll', handleScroll);
});

function trackMousePosition(event) {
    mousePosition.value = { x: event.clientX, y: event.clientY };
    if (waveSvg.value) {
        waveSvg.value.style.transform = `translateX(${(mousePosition.value.x - window.innerWidth/2) * 0.02}px) translateY(${(mousePosition.value.y - window.innerHeight/2) * 0.02}px)`;
    }
}

function handleScroll() {
    const scrollY = window.scrollY || window.pageYOffset;
    if (waveSvg.value) {
        waveSvg.value.style.transform = `translateY(${scrollY * 0.3}px)`;
    }
}

function generateWaves() {
    if (!waveSvg.value) return;
    waveSvg.value.innerHTML = '';

    for (let i = 0; i < 30; i++) {
        const y = 300 + i * 15;
        const opacity = i < 10 ? 0.2 + i * 0.08 : 1 - (i - 10) * 0.05;
        const color = i < 15 ?
            `rgba(50, 150, ${200 + i * 3}, ${opacity})` :
            `rgba(220, 220, 220, ${opacity * 0.3})`;

        const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
        path.setAttribute("d", generateWavePath(y));
        path.setAttribute("fill", "none");
        path.setAttribute("stroke", color);
        path.setAttribute("stroke-width", "1.5");
        path.style.transformOrigin = "center";
        path.style.transition = "transform 0.3s ease-out";
        path.style.animation = `waveAnimation ${3 + i * 0.1}s ease-in-out infinite ${i * 0.1}s`;
        waveSvg.value.appendChild(path);
    }
}

function generateWavePath(y) {
    const points = [];
    const segments = 20;
    const amplitude = 30 + Math.random() * 20;

    for (let i = 0; i <= segments; i++) {
        const x = (1440 / segments) * i;
        const variation = Math.sin(i * 0.5) * amplitude;
        points.push(`${x},${y - variation}`);
    }

    let path = `M${points[0]}`;
    for (let i = 1; i < points.length; i++) {
        const prev = points[i-1].split(',');
        const curr = points[i].split(',');
        const cpx1 = (Number(prev[0]) + Number(curr[0])) / 2;
        const cpy1 = Number(prev[1]);
        const cpx2 = cpx1;
        const cpy2 = Number(curr[1]);

        path += ` C${cpx1},${cpy1} ${cpx2},${cpy2} ${curr[0]},${curr[1]}`;
    }

    return path;
}

function animateText() {
    if (!animatedText.value) return;

    const text = "Budget smarter, live easier—";
    let index = 0;

    const interval = setInterval(() => {
        if (index <= text.length) {
            animatedText.value.textContent = text.substring(0, index);
            index++;
        } else {
            clearInterval(interval);
        }
    }, 100);
}

function createParticles() {
    const particleCount = 50;

    for (let i = 0; i < particleCount; i++) {
        particles.value.push({
            id: i,
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            size: Math.random() * 3 + 1,
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: (Math.random() - 0.5) * 0.5,
            color: `rgba(100, 200, 255, ${Math.random() * 0.5 + 0.1})`
        });
    }

    animateParticles();
}

function animateParticles() {
    requestAnimationFrame(() => {
        particles.value.forEach(particle => {
            particle.x += particle.speedX;
            particle.y += particle.speedY;

            if (particle.x < 0 || particle.x > window.innerWidth) {
                particle.speedX *= -1;
            }
            if (particle.y < 0 || particle.y > window.innerHeight) {
                particle.speedY *= -1;
            }
        });

        animateParticles();
    });
}

function toggleHover(state) {
    isHovering.value = state;
}
</script>

<template>
    <Head title="Welcome" />

    <div
        class="min-h-screen bg-gradient-to-br from-black to-gray-800 text-white overflow-hidden flex flex-col items-center relative"
        @mousemove="trackMousePosition"
    >
        <!-- Floating Particles -->
        <div
            v-for="particle in particles"
            :key="particle.id"
            class="absolute rounded-full pointer-events-none"
            :style="{
                left: `${particle.x}px`,
                top: `${particle.y}px`,
                width: `${particle.size}px`,
                height: `${particle.size}px`,
                backgroundColor: particle.color,
                boxShadow: `0 0 5px ${particle.color}`
            }"
        ></div>

        <!-- Navigation -->
        <nav class="w-full max-w-6xl mx-auto p-6 flex justify-between items-center relative z-10">
            <div class="font-bold text-xl hover:text-blue-400 transition-all duration-300 transform hover:scale-105">
                UNIFEIN
            </div>
            <div class="flex items-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="text-white hover:text-blue-300 transition-all duration-300 hover:underline"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="text-white hover:text-blue-300 transition-all duration-300 hover:underline px-4 py-2"
                        @mouseenter="toggleHover(true)"
                        @mouseleave="toggleHover(false)"
                    >
                        Login
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                    >
                        Sign Up
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col items-center justify-center px-6 relative z-10 max-w-4xl text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                <span ref="animatedText" class="inline-block"></span><span class="typing-cursor">|</span><br>
                track your expenses in seconds
            </h1>

            <p class="text-gray-300 mb-8 max-w-3xl text-lg">
                Take control of your finances with our intuitive budget tracker, designed
                specifically for university students to help you manage your expenses
                and save smarter.
            </p>

            <!-- Interactive CTA Button -->
            <Link
                v-if="canRegister"
                :href="route('register')"
                class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-500 transform hover:scale-110 hover:shadow-xl"
                @mouseenter="toggleHover(true)"
                @mouseleave="toggleHover(false)"
            >
                <span class="relative z-10">Get Started Now</span>
                <span
                    class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 opacity-0 transition-opacity duration-300"
                    :class="{ 'opacity-100': isHovering }"
                ></span>
                <span class="absolute inset-0 border-2 border-blue-400 rounded-lg opacity-0 transition-all duration-500 scale-90"
                    :class="{ 'opacity-100 scale-100': isHovering }"></span>
            </Link>

            <!-- Animated Features with Elegant Icons -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                <div
                    class="bg-gray-900 bg-opacity-50 p-6 rounded-xl border border-gray-700 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
                    style="transition-delay: 0ms"
                >
                    <div class="text-gray-300 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Real-time Tracking</h3>
                    <p class="text-gray-400">Monitor your spending as it happens with live updates</p>
                </div>

                <div
                    class="bg-gray-900 bg-opacity-50 p-6 rounded-xl border border-gray-700 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
                    style="transition-delay: 100ms"
                >
                    <div class="text-gray-300 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Smart Analytics</h3>
                    <p class="text-gray-400">Detailed insights into your spending patterns</p>
                </div>

                <div
                    class="bg-gray-900 bg-opacity-50 p-6 rounded-xl border border-gray-700 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
                    style="transition-delay: 200ms"
                >
                    <div class="text-gray-300 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Budget Goals</h3>
                    <p class="text-gray-400">Set and achieve your financial objectives</p>
                </div>
            </div>
        </main>

        <!-- Wave Background -->
        <div class="absolute bottom-0 left-0 w-full h-1/2 overflow-hidden z-0">
            <svg
                ref="waveSvg"
                class="w-full h-full transition-transform duration-300 ease-out"
                viewBox="0 0 1440 400"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <!-- Waves will be generated here dynamically -->
            </svg>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions for interactive elements */
a, button {
    transition: all 0.3s ease;
}

/* Typing cursor animation */
.typing-cursor {
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

/* Wave animation */
@keyframes waveAnimation {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Better wave container sizing */
@media (max-height: 700px) {
    .absolute {
        height: 40%;
    }
}

/* Hover effects */
.feature-card:hover {
    box-shadow: 0 10px 25px rgba(0, 150, 255, 0.2);
}

/* Particle animation */
.particle {
    will-change: transform;
}

/* Navigation link alignment */
nav .flex.items-center {
    align-items: center;
}
</style>
