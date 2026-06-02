<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ConfeccaoTB — Gestão Têxtil Premium</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --brand-primary: #4f46e5; --brand-secondary: #9333ea; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Bricolage Grotesque', sans-serif; letter-spacing: -0.04em; }
        
        /* Glassmorphism & Effects */
        .glass-nav { @apply bg-white/70 backdrop-blur-xl border-b border-white/20 shadow-sm; }
        .text-gradient { @apply bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500; }
        .hero-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(147, 51, 234, 0.05) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(236, 72, 153, 0.05) 0px, transparent 50%);
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .shine-effect { position: relative; overflow: hidden; }
        .shine-effect::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg); transition: 0.7s;
        }
        .shine-effect:hover::after { left: 120%; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-slate-900 selection:bg-indigo-100">

    <nav class="fixed top-0 w-full z-50 transition-all duration-500 h-20 flex items-center glass-nav">
        <div class="max-w-7xl mx-auto px-6 w-full flex items-center justify-between">
            <div class="flex items-center gap-2.5 group cursor-pointer">
                <div class="w-11 h-11 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-500">
                    <span class="text-white font-bold text-2xl tracking-tighter">C</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight">Confeccao<span class="text-indigo-600">TB</span></span>
            </div>

            <div class="hidden lg:flex items-center gap-10 text-[15px] font-medium text-slate-600">
                <a href="#features" class="hover:text-indigo-600 transition-colors">Plataforma</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Ecossistema</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Preços</a>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full text-sm font-semibold bg-slate-900 text-white hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="shine-effect px-7 py-3 bg-indigo-600 text-white rounded-full text-sm font-bold shadow-xl shadow-indigo-500/25 active:scale-95 transition-all">
                                Começar Grátis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="hero-mesh pt-20">
        <section class="relative max-w-7xl mx-auto px-6 pt-20 pb-32 lg:pt-32 lg:pb-52 overflow-visible">
            <div class="text-center">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm mb-10 animate-fade-in">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-600 shadow-[0_0_8px_rgba(79,70,229,0.8)]"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-slate-500">Versão 2026: Controle de Lotes IA</span>
                </div>

                <h1 class="text-6xl md:text-8xl lg:text-[105px] font-extrabold leading-[0.95] mb-10 tracking-tighter">
                    O cérebro da sua <br>
                    <span class="text-gradient">confecção têxtil.</span>
                </h1>
                
                <p class="text-lg md:text-2xl text-slate-500 mb-14 max-w-3xl mx-auto leading-relaxed font-light">
                    Abandone planilhas arcaicas. Domine sua produção com inteligência de dados, 
                    rastreabilidade total e design de classe mundial.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-indigo-600 text-white rounded-3xl font-bold text-xl shadow-2xl shadow-indigo-500/30 hover:bg-indigo-700 hover:-translate-y-1.5 transition-all duration-300">
                        Criar Conta Premium
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-10 py-5 bg-white border border-slate-200 rounded-3xl font-bold text-xl hover:bg-slate-50 transition-all">
                        Ver Recursos
                    </a>
                </div>
            </div>

            <div class="mt-28 relative max-w-6xl mx-auto">
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-purple-300/20 blur-3xl rounded-full animate-float"></div>
                <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-indigo-300/20 blur-3xl rounded-full animate-float" style="animation-delay: -3s"></div>
                
                <div class="relative rounded-[2.5rem] border border-white p-3 bg-white/40 backdrop-blur-md shadow-2xl overflow-hidden group">
                    <div class="rounded-[2rem] overflow-hidden border border-slate-200 aspect-video bg-slate-900 shadow-inner flex items-center justify-center">
                        <div class="text-center">
                             <div class="w-20 h-20 border-t-2 border-indigo-500 rounded-full animate-spin mx-auto mb-6"></div>
                             <p class="text-slate-500 font-mono text-xs tracking-widest uppercase">System Interface Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="max-w-7xl mx-auto px-6 py-32">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-10 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-3 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mb-10 shadow-lg shadow-indigo-100 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Gestão de Lotes</h3>
                    <p class="text-slate-500 leading-relaxed text-lg font-light">Organização cirúrgica por tamanhos, cores e estágios de produção com um clique.</p>
                </div>

                <div class="p-10 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 hover:-translate-y-3 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mb-10 shadow-lg shadow-purple-100 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Produção Instantânea</h3>
                    <p class="text-slate-500 leading-relaxed text-lg font-light">Monitore o ritmo das costureiras e da expedição em tempo real de qualquer lugar.</p>
                </div>

                <div class="p-10 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-3 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mb-10 shadow-lg shadow-emerald-100 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Financeiro Integrado</h3>
                    <p class="text-slate-500 leading-relaxed text-lg font-light">Cálculo de custo por peça e lucratividade real sincronizados com suas vendas.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-slate-100 py-20 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center font-bold text-white text-sm">C</div>
                    <span class="font-bold text-xl tracking-tighter">ConfeccaoTB</span>
                </div>
                <p class="text-slate-400 text-sm">Design & Engineered for the Fashion Industry 2026.</p>
            </div>
            
            <div class="flex gap-12 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-indigo-600 transition-colors">Instagram</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">LinkedIn</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Termos</a>
            </div>
            
            <p class="text-slate-400 text-sm">© 2026 — Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('h-16');
                nav.classList.remove('h-20');
            } else {
                nav.classList.add('h-20');
                nav.classList.remove('h-16');
            }
        });
    </script>
</body>
</html>